<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Course;
use App\Models\Quotation;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\QuotationTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\QuotationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuotationResource\RelationManagers;
use App\Models\UserTrainer;
use Filament\Forms\Components\DatePicker;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        //     // quotation template
        //     $table->foreignId('quotation_template_id')->nullable()->constrained()->nullOnDelete();

        //     $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

        //     $table->string('bill_to')->nullable();
        //     $table->string('tel')->nullable();
        //     $table->string('p_o_box')->nullable();
        //     $table->string('trn')->nullable();

        //     $table->string('tax_invoice_date')->nullable();
        //     $table->string('tax_invoice_no')->nullable();
        //     $table->string('supply_date')->nullable();
        //     $table->string('lpo_count')->nullable();

        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    // Type : Quotation, Invoice

                    Select::make('type')
                        ->label('Type')
                        ->options([
                            'quotation' => 'Quotation',
                            'invoice' => 'Invoice',
                        ])
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),


                    Select::make('quotation_template_id')
                        ->label('Quotation Template')
                        ->options(function () {
                            return QuotationTemplate::get()->pluck('company_name', 'id')->toArray();
                        })
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Select::make('user_id')
                        ->label('Student')
                        ->options(function () {
                            return UserTrainer::get()->pluck('name', 'id')->toArray();
                        })
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('bill_to')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('tel')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('p_o_box')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('trn')
                        ->label('TRN')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    DatePicker::make('tax_invoice_date')
                        ->required()
                        ->rules(['nullable', 'date'])
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('tax_invoice_no')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    DatePicker::make('supply_date')
                        ->required()
                        ->rules(['nullable', 'date'])
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    TextInput::make('lpo_count')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // Repeater for quotation items
                    Forms\Components\Repeater::make('quotationItems')
                        ->relationship('quotationItems')
                        ->schema([
                            Grid::make(['default' => 12])->schema([
                                // Courses
                                Select::make('course_id')
                                    ->label('Course')
                                    ->options(function () {
                                        return Course::get()->pluck('title', 'id')->toArray();
                                    })
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        $set('price', $get('course_id') ? Course::find($get('course_id'))->cost : null);
                                        $set('net_count', $get('price') * ((int)$get('unit') ?? 1));
                                        $set('vat_amount', $get('net_count') * 0.05);
                                        // Total
                                        $total = $get('net_count') + $get('vat_amount');
                                        $set('total', $total);
                                    })
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                TextInput::make('unit')
                                    ->label('Quantity')
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function (callable $set, callable $get) {
                                        $set('price', $get('course_id') ? Course::find($get('course_id'))->cost : null);
                                        $set('net_count', $get('price') * ((int)$get('unit') ?? 1));
                                        $set('vat_amount', $get('net_count') * 0.05);
                                        // Total
                                        $total = $get('net_count') + $get('vat_amount');
                                        $set('total', $total);
                                    })
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                TextInput::make('vat_amount')
                                    ->label('Vat Amount')
                                    ->required()
                                    ->disabled()
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                // float number
                                TextInput::make('price')
                                    ->label('Unit Price')
                                    ->required()
                                    ->disabled()
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                TextInput::make('net_count')
                                    ->label('Net Count')
                                    ->required()
                                    ->disabled()
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),

                                TextInput::make('total')
                                    ->label('Total Price')
                                    ->required()
                                    ->disabled()
                                    ->numeric()
                                    ->columnSpan([
                                        'default' => 12,
                                        'md' => 6,
                                        'lg' => 6,
                                    ]),
                            ]),
                        ])
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotationTemplate.company_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bill_to')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tel')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('print.quotation')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Quotation $record) => static::getUrl('print.quotation', $record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
            'print.quotation' => Pages\PrintQuotation::route('/{record}/print'),
        ];
    }
}
