<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\QuotationTemplate;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuotationTemplateResource\Pages;
use App\Filament\Resources\QuotationTemplateResource\RelationManagers;

class QuotationTemplateResource extends Resource
{
    protected static ?string $model = QuotationTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([
                    Forms\Components\TextInput::make('company_name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('company_phone')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('p_o_box')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('trn')
                        ->label('TRN')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('account_no')
                        ->required()
                        ->numeric()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('iban')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('bank_name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                    Forms\Components\TextInput::make('bank_account_name')
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('company_phone')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('p_o_box')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bank_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bank_account_name')->sortable()->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListQuotationTemplates::route('/'),
            'create' => Pages\CreateQuotationTemplate::route('/create'),
            'edit' => Pages\EditQuotationTemplate::route('/{record}/edit'),
        ];
    }
}
