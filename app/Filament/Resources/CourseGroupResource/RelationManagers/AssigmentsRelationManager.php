<?php

namespace App\Filament\Resources\CourseGroupResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\UserInstructor;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\{Form, Table};
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class AssigmentsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'assigments';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 12])->schema([
                
                FileUpload::make('file')
                    ->rules(['nullable', 'file'])
                    ->placeholder('File')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                    
                Select::make('user_id')
                    ->label('Instructor')
                    ->rules(['required', 'exists:users,id'])
                    ->options(function () {
                        return UserInstructor::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->placeholder('Select instructor')
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

                DatePicker::make('dead_line')
                    ->rules(['nullable', 'date'])
                    ->placeholder('Dead Line')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

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

                RichEditor::make('body')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Body')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Instructor')->limit(50),
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
                Tables\Columns\TextColumn::make('points'),
                Tables\Columns\TextColumn::make('body')->limit(50),
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
                                fn(
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
                                fn(
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

                SelectFilter::make('course_group_id')->relationship(
                    'courseGroup',
                    'name'
                ),
            ]);
    }
}
