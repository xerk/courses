<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\Trainer;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\TrainerResource\Pages;

class TrainerResource extends Resource
{
    protected static ?string $model = Trainer::class;

    protected static ?string $navigationGroup = 'Main';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'occupation';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    static::getTrainerForm(true)
                ]),
            ]),
        ]);
    }

    public static function getUserRelation()
    {
        return Select::make('user_id')
            ->rules(['required', 'exists:users,id'])
            ->relationship('user', 'name')
            ->preload()
            ->searchable()
            ->placeholder('User')
            ->columnSpan([
                'default' => 12,
                'md' => 6,
                'lg' => 6,
            ]);
    }
    public static function getTrainerForm($relation = false)
    {

        $schema = [];

        if ($relation) {
            $schema[] = static::getUserRelation();
        }

        $schema = array_merge($schema, [
            TextInput::make('student_code')
                ->rules(['required', 'max:255', 'string'])
                ->placeholder('Student Code')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('occupation')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Occupation')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('work_place')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Work Place')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            TextInput::make('job_title')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Job Title')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ]),

            Toggle::make('company')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ])->inline(false)->default(false)
                ->reactive(),

            Select::make('company_id')
                ->rules(['required', 'exists:companies,id'])
                ->relationship('company', 'name')
                ->preload()
                ->searchable()
                ->placeholder('Company')
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ])->hidden(fn (Closure $get) => $get('company') !== true),

            Toggle::make('sufer_diseases')
                ->label('Health Status')
                ->rules(['nullable', 'max:255'])
                ->columnSpan([
                    'default' => 12,
                    'md' => 6,
                    'lg' => 6,
                ])->reactive(),

            RichEditor::make('diseases_note')
                ->label('Health Note')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Diseases Note')
                ->columnSpan([
                    'default' => 12,
                    'md' => 12,
                    'lg' => 12,
                ])->hidden(fn (Closure $get) => $get('sufer_diseases') !== true),


            RichEditor::make('note')
                ->rules(['nullable', 'max:255', 'string'])
                ->placeholder('Note')
                ->columnSpan([
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainers::route('/'),
            'create' => Pages\CreateTrainer::route('/create'),
            'edit' => Pages\EditTrainer::route('/{record}/edit'),
        ];
    }
}
