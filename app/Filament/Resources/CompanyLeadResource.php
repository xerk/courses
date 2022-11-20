<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\CompanyLead;
use App\Models\SubCategory;
use Filament\{Tables, Forms};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\{Form, Table, Resource};
use App\Filament\Resources\CompanyLeadResource\Pages;

class CompanyLeadResource extends Resource
{
    protected static ?string $label = 'Sales Follow-ups';

    protected static ?string $navigationGroup = 'Sales Protal';

    protected static ?string $model = CompanyLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        $query = static::getModel()::query();
        if (auth()->user()->type === 'sales') {
            $query->where('sales_id', auth()->user()->id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        $followUps = Repeater::make('FollowUps')
            ->relationship('followUps')
            ->schema([
                FollowUpResource::getFollowUpForm()
            ])->columnSpan('full');
        if (auth()->user()->type == 'sales') {
            $followUps->disableItemDeletion();
            $followUps->disableItemMovement();
        }
        return $form->schema([
            static::getCompanyLeadForm(),

            $followUps
        ]);
    }

    public static function getCompanyLeadForm()
    {
        return Section::make('Company Lead')->schema([
            Grid::make(['default' => 12])->schema([
                Select::make('sales_id')
                    ->rules(['required'])
                    ->relationship('sales', 'name')
                    ->preload()
                    ->searchable()
                    ->placeholder('Select Sales')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('name')
                    ->label('Company Name')
                    ->rules(['required', 'max:255', 'string'])
                    ->placeholder('Company Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('name_ar')
                    ->label('Company Name AR')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Company Name AR')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('email')
                    ->rules(['required', 'email'])
                    ->email()
                    ->placeholder('Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('business_email')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Business Email')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('phone')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Phone')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('business_landline')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Business Landline')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                Select::make('category_id')
                    ->rules(['required'])
                    ->options(Category::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->placeholder('Category')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('sub_category_id', null)),

                Select::make('sub_category_id')
                    ->rules(['required'])
                    ->options(function (callable $get) {
                        $category = Category::find($get('category_id'));
                        if (!$category) {
                            return SubCategory::all()->pluck('name', 'id');
                        }
                        return $category->subCategories->pluck('name', 'id');
                    })
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                TextInput::make('status')
                    ->rules(['nullable', 'max:255', 'string'])
                    ->placeholder('Status')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
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
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('end_date')->date()->color(function (TextColumn $column) {
                    $date = new Carbon($column->getState());
                    $now = Carbon::now()->format('Y-m-d');
                    if ($date->format('Y-m-d') < $now) {
                        return 'danger';
                    }
                    if ($date->subMonths(3)->format('Y-m-d') > $now) {
                        return 'success';
                    }
                    if (new Carbon($column->getState()) > $now) {
                        return 'warning';
                    }
                }),
                // Tables\Columns\TextColumn::make('name_ar')->limit(50),
                Tables\Columns\TextColumn::make('email')->limit(50),
                // Tables\Columns\TextColumn::make('business_email')->limit(50),
                Tables\Columns\TextColumn::make('phone')->limit(50),
                // Tables\Columns\TextColumn::make('business_landline')->limit(50),
                Tables\Columns\TextColumn::make('complete_with')->limit(50),
                // Tables\Columns\TextColumn::make('start_date')->date(),
                // Tables\Columns\TextColumn::make('category.name')->limit(50),
                // Tables\Columns\TextColumn::make('category_approved')->limit(50),
                // Tables\Columns\TextColumn::make('status')->limit(50),
                // Tables\Columns\TextColumn::make('note')->limit(50),
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

                MultiSelectFilter::make('category_id')->relationship(
                    'category',
                    'name'
                ),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyLeads::route('/'),
            'create' => Pages\CreateCompanyLead::route('/create'),
            'edit' => Pages\EditCompanyLead::route('/{record}/edit'),
        ];
    }
}
