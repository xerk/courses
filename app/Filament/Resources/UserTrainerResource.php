<?php

namespace App\Filament\Resources;

use App\Models\User;
use Livewire\Component;
use App\Models\UserTrainer;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\UserTrainerResource\Pages;

class UserTrainerResource extends Resource
{
    protected static ?string $label = 'Students';

    protected static ?string $slug = 'user-students';

    protected static ?string $model = UserTrainer::class;

    protected static ?string $navigationGroup = 'User Managment';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();
        if (auth()->user()->type === 'instructor') {
            $query->has('courseGroups');
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            UserAdminResource::getUserForm('trainer'),
            UserAdminResource::getUserRoleForm(),

            Section::make('Student Data')->relationship('trainer')->schema([
                TrainerResource::getTrainerForm()
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

                SelectFilter::make('category')->relationship(
                    'category',
                    'name'
                )->multiple(),

                SelectFilter::make('company')->relationship(
                    'company',
                    'name'
                )->multiple(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserTrainerResource\RelationManagers\CoursesRelationManager::class,
            UserTrainerResource\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserTrainers::route('/'),
            'create' => Pages\CreateUserTrainer::route('/create'),
            'edit' => Pages\EditUserTrainer::route('/{record}/edit'),
        ];
    }
}
