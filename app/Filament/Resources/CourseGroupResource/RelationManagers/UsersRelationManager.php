<?php

namespace App\Filament\Resources\CourseGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\{Form, Table};
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\AttachAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use App\Filament\Resources\CourseGroupResource\Pages;
use Filament\Resources\RelationManagers\RelationManager;

class UsersRelationManager extends RelationManager
{
    protected static ?string $label = 'Stundet';

    protected static ?string $pluralLabel = 'Students';

    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->rounded(),
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('email')->limit(50),
                Tables\Columns\TextColumn::make('phone')->limit(50),
                Tables\Columns\TextColumn::make('category.name')->limit(50),
                Tables\Columns\TextColumn::make('company.name')->limit(50),
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

                MultiSelectFilter::make('category_id')->relationship(
                    'category',
                    'name'
                ),

                MultiSelectFilter::make('company_id')->relationship(
                    'company',
                    'name'
                ),
            ])->headerActions([
                AttachAction::make()->label('Assign Student')->recordSelect(function (Select $select) {
                    return $select->multiple();
                })->recordSelectOptionsQuery(fn (Builder $query) => $query->where('type', '=', 'trainer'))
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
