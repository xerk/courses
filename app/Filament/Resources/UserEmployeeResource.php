<?php

namespace App\Filament\Resources;

use App\Models\User;
use Livewire\Component;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\UserEmployeeResource\Pages;

class UserEmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'Employee';

    protected static ?string $slug = 'user-employees';

    protected static ?string $navigationGroup = 'User Managment';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('type', 'employee');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            UserResource::getUserForm('employee'),
            UserResource::getUserRoleForm(),

            Section::make('Employee Data')->relationship('employee')->schema([
                EmployeeResource::getEmployeeForm()
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->rounded(),
                Tables\Columns\TextColumn::make('name')->limit(30),
                Tables\Columns\TextColumn::make('email')->limit(30),
                Tables\Columns\TextColumn::make('private_email')->limit(30),
                Tables\Columns\TextColumn::make('phone')->limit(30),
                Tables\Columns\TextColumn::make('category.name')->limit(30),
                Tables\Columns\TextColumn::make('city')->limit(30),
                Tables\Columns\TextColumn::make('country')->limit(30),
                Tables\Columns\TextColumn::make('company.name')->limit(30),
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

                SelectFilter::make('company_id')->relationship(
                    'company',
                    'name'
                )->multiple(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserEmployees::route('/'),
            'create' => Pages\CreateUserEmployee::route('/create'),
            'edit' => Pages\EditUserEmployee::route('/{record}/edit'),
        ];
    }
}
