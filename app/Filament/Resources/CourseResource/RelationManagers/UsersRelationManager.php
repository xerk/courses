<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Resources\{Form, Table};
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\CourseResource\Pages;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;

class UsersRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 12])->schema([
                TextInput::make('name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('name_ar')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Name Ar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('avatar')
                    ->rules(['nullable', 'file'])
                    ->image()
                    ->placeholder('Avatar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->unique('users', 'email', fn (?Model $record) => $record)
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('private_email')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->email()
                    ->placeholder('Private Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                    ->required(
                        fn (Component $livewire) => $livewire instanceof
                            Pages\CreateUser
                    )
                    ->placeholder('Password')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('phone')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Phone')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('phone2')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Phone2')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('address')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Address')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('inside_address')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Inside Address')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('type')
                    ->rules(['nullable', 'in:trainer,employee,admin'])
                    ->searchable()
                    ->options([
                        'trainer' => 'Student',
                        'employee' => 'Employee',
                        'admin' => 'Admin',
                    ])
                    ->placeholder('Type')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('category_id')
                    ->rules(['nullable', 'exists:categories,id'])
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('city')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('City')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('country')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Country')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('company_id')
                    ->rules(['nullable', 'exists:companies,id'])
                    ->relationship('company', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('Company')
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
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('name_ar')->limit(50),
                Tables\Columns\ImageColumn::make('avatar')->rounded(),
                Tables\Columns\TextColumn::make('email')->limit(50),
                Tables\Columns\TextColumn::make('private_email')->limit(50),
                Tables\Columns\TextColumn::make('phone')->limit(50),
                Tables\Columns\TextColumn::make('phone2')->limit(50),
                Tables\Columns\TextColumn::make('address')->limit(50),
                Tables\Columns\TextColumn::make('inside_address')->limit(50),
                Tables\Columns\TextColumn::make('type')->enum([
                    'trainer' => 'Student',
                    'employee' => 'Employee',
                    'admin' => 'Admin',
                ]),
                Tables\Columns\TextColumn::make('category.name')->limit(50),
                Tables\Columns\TextColumn::make('city')->limit(50),
                Tables\Columns\TextColumn::make('country')->limit(50),
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
}
