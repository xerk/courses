<?php

namespace App\Filament\Resources\AssigmentResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\{Form, Table};
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Relations\Relation;
use Filament\Resources\RelationManagers\RelationManager;

class AssigmentAnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'assigmentAnswers';

    protected static ?string $recordTitleAttribute = 'file';

    public function getRelationship(): Relation | Builder
    {
        if (auth()->user()->type === 'trainer') {
            return $this->getOwnerRecord()->{static::getRelationshipName()}()->where('user_id', auth()->user()->id);
        }
        return $this->getOwnerRecord()->{static::getRelationshipName()}();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 12])->schema(array_merge(static::studentNotLogin(), [
                FileUpload::make('file')
                    ->rules(['nullable', 'file'])
                    ->placeholder('File')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ])),
        ]);
    }

    public static function studentNotLogin()
    {
        $userId = Select::make('user_id')
            ->label('Student')
            ->rules(['required'])
            ->relationship('user', 'name')
            ->options(function () {
                return User::where('type', 'trainer')->get()->pluck('name', 'id');
            })
            ->searchable()
            ->placeholder('User')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        $status =  Select::make('status')
            ->rules([
                'nullable',
                'in:approved,rejected,pending,processing',
            ])
            ->searchable()
            ->options([
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'pending' => 'Pending',
                'processing' => 'Processing',
            ])
            ->placeholder('Status')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        $reason = RichEditor::make('reason')
            ->rules(['nullable', 'max:255', 'string'])
            ->placeholder('Reason')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        $points = TextInput::make('points')
            ->rules(['required', 'numeric'])
            ->numeric()
            ->placeholder('Points')
            ->default('0')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        if (auth()->user()->type === 'trainer') {
            $points->hiddenOn(['create', 'edit']);
            $userIdHidden = Hidden::make('user_id')->default(auth()->user()->id);
            $userId->hiddenOn(['create', 'edit']);
            $status->hiddenOn(['create', 'edit']);
            $reason->hiddenOn(['create', 'edit']);
        }

        return [
            $userIdHidden,
            $userId,
            $points,
            $status,
            $reason,
        ];
    }

    public static function inlineTableEdit()
    {
        if (auth()->user()->type !== 'trainer') {
            return Tables\Columns\SelectColumn::make('status')->options([
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'pending' => 'Pending',
                'processing' => 'Processing',
            ])->disablePlaceholderSelection();
        }
        return Tables\Columns\TextColumn::make('status')->enum([
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'pending' => 'Pending',
            'processing' => 'Processing',
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->limit(50)->label('Student'),
                Tables\Columns\TextColumn::make('assigment.title')->limit(50),
                Tables\Columns\TextColumn::make('instructor.name')->limit(50),
                static::inlineTableEdit(),
                Tables\Columns\TextColumn::make('reason')->limit(50),
                Tables\Columns\TextColumn::make('points'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn (
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                SelectFilter::make('user')->relationship(
                    'user',
                    'name'
                ),

                SelectFilter::make('assigment')->relationship(
                    'assigment',
                    'title'
                ),

                SelectFilter::make('instructor')->relationship(
                    'instructor',
                    'name'
                ),
            ])->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
