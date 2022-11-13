<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Assigment;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\AssigmentResource\Pages;

class AssigmentResource extends Resource
{
    protected static ?string $model = Assigment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Main';

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();
        if (auth()->user()->type === 'trainer') {
            $query->whereHas('courseGroup', function ($q) {
                $q->whereHas('users', function ($q) {
                    $q->where('type', 'trainer')->where('id', auth()->user()->id);
                });
            });
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([

                    Select::make('user_id')
                        ->label('Instructor')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('user', 'name')
                        ->options(function () {
                            return User::where('type', 'instractor')->get()->pluck('name', 'id');
                        })
                        ->searchable()
                        ->placeholder('Select an instructor')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    Select::make('course_group_id')
                        ->rules(['required', 'exists:course_groups,id'])
                        ->relationship('courseGroup', 'name')
                        ->searchable()
                        ->placeholder('Course Group')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    TextInput::make('title')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    DateTimePicker::make('dead_line')
                        ->rules(['nullable', 'date'])
                        ->placeholder('Dead Line')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ])->timezone('Africa/Cairo'),

                    TextInput::make('points')
                        ->rules(['required', 'numeric'])
                        ->numeric()
                        ->placeholder('Points')
                        ->default('0')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    FileUpload::make('file')
                        ->rules(['nullable', 'file'])
                        ->placeholder('File')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    RichEditor::make('body')
                        ->rules(['nullable', 'max:255', 'string'])
                        ->placeholder('Body')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->limit(50),
                Tables\Columns\TextColumn::make('courseGroup.name')->limit(50),
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('dead_line')->date()->color(function (TextColumn $column) {
                    $date = new Carbon($column->getState());
                    $now = new Carbon();
                    // dd($date > $now,);
                    if ($date < $now) {
                        return 'danger';
                    }
                    if ($date->subDay() >= $now) {
                        return 'success';
                    }
                    if (new Carbon($column->getState()) > $now) {
                        return 'warning';
                    }
                }),
                Tables\Columns\TextColumn::make('assigment_answers_count')->counts('assigmentAnswers')->hidden(auth()->user()->type == 'trainer'),
                Tables\Columns\TextColumn::make('points'),
                // Tables\Columns\TextColumn::make('body')->limit(50),
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

                MultiSelectFilter::make('user_id')->relationship(
                    'user',
                    'name'
                ),

                MultiSelectFilter::make('course_group_id')->relationship(
                    'courseGroup',
                    'name'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AssigmentResource\RelationManagers\AssigmentAnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssigments::route('/'),
            'create' => Pages\CreateAssigment::route('/create'),
            'view' => Pages\ViewAssigment::route('/{record}'),
            'edit' => Pages\EditAssigment::route('/{record}/edit'),
        ];
    }
}
