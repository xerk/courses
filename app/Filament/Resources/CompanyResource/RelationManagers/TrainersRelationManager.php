<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class TrainersRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'trainers';

    protected static ?string $recordTitleAttribute = 'occupation';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 12])->schema([
                Select::make('user_id')
                    ->rules(['required', 'exists:users,id'])
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('User')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('company')
                    ->rules(['nullable', 'max:255'])
                    ->placeholder('Company')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('occupation')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Occupation')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('work_place')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Work Place')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('sufer_diseases')
                    ->rules(['nullable', 'max:255'])
                    ->label('Health Status')
                    ->placeholder('Sufer Diseases')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->reactive(),

                RichEditor::make('diseases_note')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->label('Health Note')
                    ->placeholder('Diseases Note')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])->hidden(fn (Closure $get) => $get('sufer_diseases') !== true),

                TextInput::make('job_title')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Job Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                RichEditor::make('note')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Note')
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
                Tables\Columns\TextColumn::make('user.name')->limit(50),
                Tables\Columns\TextColumn::make('company')->limit(50),
                Tables\Columns\TextColumn::make('company.name')->limit(50),
                Tables\Columns\TextColumn::make('occupation')->limit(50),
                Tables\Columns\TextColumn::make('work_place')->limit(50),
                Tables\Columns\TextColumn::make('sufer_diseases')->label('Health Status')->limit(50),
                Tables\Columns\TextColumn::make('diseases_note')->limit(50),
                Tables\Columns\TextColumn::make('job_title')->limit(50),
                Tables\Columns\TextColumn::make('note')->limit(50),
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
                )->multiple(),

                SelectFilter::make('company_id')->relationship(
                    'company',
                    'name'
                )->multiple(),
            ]);
    }
}
