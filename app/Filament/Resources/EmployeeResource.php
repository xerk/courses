<?php

namespace App\Filament\Resources;

use App\Models\Employee;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\EmployeeResource\Pages;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'joining_date';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                static::getEmployeeForm(true)
            ])
        ]);
    }

    public static function getUserRelation() {
        return Select::make('user_id')
                ->rules(['required', 'exists:users,id'])
                ->relationship('user', 'name')
                ->searchable()
                ->placeholder('User')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]);
    }

    public static function getEmployeeForm($relation = false) {
         
        $schema = [];

        if ($relation) {
            $schema[] = static::getUserRelation();
        }

        $schema = array_merge($schema, [
            DatePicker::make('joining_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Joining Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('passport_id')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Passport Id')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('passport_realse_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Passport Realse Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('passport_expire_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Passport Expire Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('national_id')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('National Id')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('national_realse_date')
                ->rules(['nullable', 'date'])
                ->placeholder('National Realse Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('national_expire_date')
                ->rules(['nullable', 'date'])
                ->placeholder('National Expire Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('health_certificate_no')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Health Certificate No')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('health_realse_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Health Realse Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            DatePicker::make('health_expire_date')
                ->rules(['nullable', 'date'])
                ->placeholder('Health Expire Date')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('gross_salary')
                ->rules(['nullable', 'numeric'])
                ->numeric()
                ->placeholder('Gross Salary')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('net_salary')
                ->rules(['nullable', 'numeric'])
                ->numeric()
                ->placeholder('Net Salary')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('allowances')
                ->rules(['nullable', 'numeric'])
                ->numeric()
                ->placeholder('Allowances')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('yearly_vacation')
                ->rules(['nullable', 'numeric'])
                ->numeric()
                ->placeholder('Yearly Vacation')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('vacation_balance')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Vacation Balance')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('emergancy_name')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Emergancy Name')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('emergancy_phone')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Emergancy Phone')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('emergancy_relative_relation')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Emergancy Relative Relation')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ]),

            RichEditor::make('note')->columnSpan([
                'default' => 12,
                'md' => 12,
                'lg' => 12,
            ]),
        ]);

        return Grid::make(['default' => 12])->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->limit(50),
                Tables\Columns\TextColumn::make('joining_date')->date(),
                Tables\Columns\TextColumn::make('passport_id')->limit(50),
                Tables\Columns\TextColumn::make('passport_realse_date')->date(),
                Tables\Columns\TextColumn::make('passport_expire_date')->date(),
                Tables\Columns\TextColumn::make('national_id')->limit(50),
                Tables\Columns\TextColumn::make('national_realse_date')->date(),
                Tables\Columns\TextColumn::make('national_expire_date')->date(),
                Tables\Columns\TextColumn::make('health_certificate_no')->limit(
                    50
                ),
                Tables\Columns\TextColumn::make('health_realse_date')->date(),
                Tables\Columns\TextColumn::make('health_expire_date')->date(),
                Tables\Columns\TextColumn::make('gross_salary'),
                Tables\Columns\TextColumn::make('net_salary'),
                Tables\Columns\TextColumn::make('allowances'),
                Tables\Columns\TextColumn::make('yearly_vacation'),
                Tables\Columns\TextColumn::make('vacation_balance')->limit(50),
                Tables\Columns\TextColumn::make('emergancy_name')->limit(50),
                Tables\Columns\TextColumn::make('emergancy_phone')->limit(50),
                Tables\Columns\TextColumn::make(
                    'emergancy_relative_relation'
                )->limit(50),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
