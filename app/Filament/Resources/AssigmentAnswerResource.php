<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\{Tables, Forms};
use App\Models\AssigmentAnswer;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\AssigmentAnswerResource\Pages;
use App\Models\UserTrainer;

class AssigmentAnswerResource extends Resource
{
    protected static ?string $model = AssigmentAnswer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Education Portal';

    protected static ?string $recordTitleAttribute = 'file';

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();
        if (auth()->user()->type === 'trainer') {
            $query->where('user_id', auth()->user()->id)->whereHas('assigment', function ($q) {
                $q->whereHas('courseGroup', function ($q) {
                    $q->whereHas('users', function ($q) {
                        $q->where('type', 'trainer')->where('id', auth()->user()->id);
                    });
                });
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema(
                    static::studentNotLogin()
                ),
            ]),
        ]);
    }

    public static function studentNotLogin()
    {
        $assigmentId = Select::make('assigment_id')
            ->rules(['required'])
            ->relationship('assigment', 'title')
            ->preload()
            ->searchable()
            ->placeholder('Assigment')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        $file = FileUpload::make('file')
            ->rules(['nullable', 'file'])
            ->placeholder('File')
            ->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]);

        $userId = Select::make('user_id')
            ->label('Student')
            ->preload()
            ->rules(['required'])
            ->relationship('user', 'name')
            ->options(function () {
                return UserTrainer::all()->pluck('name', 'id');
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
        $userIdHidden = Hidden::make('token')->default('');
        if (auth()->user()->type === 'trainer') {
            $points->hiddenOn(['create', 'edit']);
            $userId->hiddenOn(['create', 'edit']);
            $userIdHidden = Hidden::make('user_id')->default(auth()->user()->id);
            $status->hiddenOn(['create', 'edit']);
            $reason->hiddenOn(['create', 'edit']);
        } else if (auth()->user()->type === 'instructor') {
            $assigmentId->hiddenOn(['edit']);
            $file->hiddenOn(['edit']);
            $userId->hiddenOn(['edit']);
        }

        return [
            $assigmentId,
            $file,
            $userIdHidden,
            $userId,
            $points,
            $status,
            $reason,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->limit(50)->label('Student'),
                Tables\Columns\TextColumn::make('assigment.title')->limit(50),
                Tables\Columns\TextColumn::make('instructor.name')->limit(50),
                Tables\Columns\TextColumn::make('status')->enum([
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                ]),
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

                SelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),

                SelectFilter::make('assigment_id')->relationship(
                    'assigment',
                    'title'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssigmentAnswers::route('/'),
            'create' => Pages\CreateAssigmentAnswer::route('/create'),
            'view' => Pages\ViewAssigmentAnswer::route('/{record}'),
            'edit' => Pages\EditAssigmentAnswer::route('/{record}/edit'),
        ];
    }
}
