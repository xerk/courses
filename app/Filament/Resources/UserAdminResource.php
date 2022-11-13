<?php

namespace App\Filament\Resources;

use App\Models\User;
use Livewire\Component;
use Filament\Pages\Page;
use App\Models\UserAdmin;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\MorphToSelect;
use App\Filament\Resources\UserAdminResource\Pages;
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class UserAdminResource extends Resource
{
    protected static ?string $model = UserAdmin::class;

    protected static ?string $label = 'Admins';

    protected static ?string $navigationGroup = 'User Managment';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'name';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            static::getUserForm(),
            static::getUserRoleForm()
        ]);
    }

    public static function getTypeForm($type, $typeDisplay)
    {
        if ($typeDisplay) {
            return Select::make('type')
                ->options([
                    'employee' => 'Employee',
                    'instructor' => 'Instructor',
                ])
                ->searchable()
                ->placeholder('Select Type')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 4,
                ]);
        }
        return Hidden::make('type')->default($type);
    }

    public static function getUserForm($type = 'admin', $typeDisplay = false)
    {
        return Section::make('User Information')->schema([
            Grid::make(['default' => 12])->schema([
                FileUpload::make('avatar')
                    ->rules(['nullable', 'file'])
                    ->image()
                    ->placeholder('Avatar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                TextInput::make('username')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Username')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('name_ar')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Name Ar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->unique(
                        'users',
                        'email',
                        fn (?Model $record) => $record
                    )
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('private_email')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->email()
                    ->placeholder('Private Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->required(fn (Page $livewire) => ($livewire instanceof CreateRecord))
                    ->dehydrated(fn ($state) => filled($state))
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
                        'lg' => 6,
                    ]),

                TextInput::make('phone2')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Phone2')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('address')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Address')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                TextInput::make('inside_address')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Inside Address')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                static::getTypeForm($type, $typeDisplay),
                Select::make('category_id')
                    ->rules(['nullable', 'exists:categories,id'])
                    ->relationship('category', 'name')
                    ->searchable()
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 4,
                    ]),

                TextInput::make('city')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('City')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 4,
                    ]),

                TextInput::make('country')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Country')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),

                Select::make('company_id')
                    ->rules(['nullable', 'exists:companies,id'])
                    ->relationship('company', 'name')
                    ->searchable()
                    ->placeholder('Company')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 6,
                    ]),


                SpatieMediaLibraryFileUpload::make('documents')
                    ->multiple()
                    ->enableReordering()
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function getUserRoleForm($type = 'admin')
    {
        return Section::make('User Roles')->schema([
            CheckboxList::make('roles')->relationship('roles', 'name')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->rounded(),
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('email')->limit(50),
                Tables\Columns\TextColumn::make('phone')->limit(50),
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

    public static function getRelations(): array
    {
        return [
            // UserAdminResource\RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
