<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class CoursesRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 12])->schema([
                Select::make('category_id')
                    ->rules(['required', 'exists:categories,id'])
                    ->relationship('category', 'name')
                    ->searchable()
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('title')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('cost')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Cost')
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
                Tables\Columns\TextColumn::make('category.name')->limit(50),
                Tables\Columns\TextColumn::make('title')->limit(50),
                Tables\Columns\TextColumn::make('cost')->limit(50),
                Tables\Columns\TextColumn::make('courses.ending_date')->date(),
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

                SelectFilter::make('category_id')->relationship(
                    'category',
                    'name'
                )->multiple(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        Grid::make(['default' => 12])->schema([
                            $action->getRecordSelect()->placeholder('Select course')->preload()
                                ->columnSpan([
                                    'default' => 12,
                                ]),
                            DatePicker::make('starting_date')
                                ->rules(['required', 'date'])
                                ->placeholder('Starting Date')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),


                            DatePicker::make('ending_date')
                                ->rules(['required', 'date'])
                                ->placeholder('Ending Date')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('duration_days')
                                ->rules(['required'])
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(5000)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),


                            Select::make('training_method')
                                ->rules(['required'])
                                ->options([
                                    'online' => 'Online',
                                    'offline' => 'Offline',
                                ])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),


                            TextInput::make('training_vinue')->maxLength(255)
                                ->rules(['required'])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('certificate_no')
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('invoice_no')
                                ->rules(['required'])
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            DatePicker::make('issuing_date')
                                ->rules(['nullable', 'date'])
                                ->placeholder('Payment Date')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('paid_amount')->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'AED ', thousandsSeparator: ',', decimalPlaces: 2))
                                ->rules(['required'])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('remain_amount')->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'AED ', thousandsSeparator: ',', decimalPlaces: 2))
                                ->rules(['required'])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('invoice_amount')->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'AED ', thousandsSeparator: ',', decimalPlaces: 2))
                                ->rules(['required'])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            TextInput::make('total_payment')->mask(fn (TextInput\Mask $mask) => $mask->money(prefix: 'AED ', thousandsSeparator: ',', decimalPlaces: 2))
                                ->rules(['required'])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            DatePicker::make('payment_date')
                                ->rules(['required', 'date'])
                                ->placeholder('Payment Date')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 6,
                                ]),

                            Select::make('payment_method')
                                ->rules(['required'])
                                ->options([
                                    'bank' => 'Bank',
                                    'cash' => 'Cash',
                                ])
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 6,
                                ]),

                            Toggle::make('paid_status')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),


                            Toggle::make('receipt_certificate')
                                ->columnSpan([
                                    'default' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ]),

                            RichEditor::make('note')
                                ->columnSpan([
                                    'default' => 12,
                                ]),

                        ]),
                    ])
                    ->modalWidth('5xl')->label('Assign Course'),
            ])->actions([
                // ...
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                // ...
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
