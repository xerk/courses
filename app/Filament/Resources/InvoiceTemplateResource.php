<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\InvoiceTemplate;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvoiceTemplateResource\Pages;
use App\Filament\Resources\InvoiceTemplateResource\RelationManagers;

class InvoiceTemplateResource extends Resource
{
    protected static ?string $model = InvoiceTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(['default' => 12])->schema([
                        Forms\Components\TextInput::make('title_ar')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('title_en')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('commercial_no')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('vat_no')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        Forms\Components\TextInput::make('address_ar')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('address_en')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),

                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('website')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('received_by')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('accountant_name')
                            ->required()
                            ->columnSpan([
                                'default' => 12,
                                'md' => 6,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('manager_name')
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
                Tables\Columns\TextColumn::make('title_ar'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('website'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInvoiceTemplates::route('/'),
            'create' => Pages\CreateInvoiceTemplate::route('/create'),
            'edit' => Pages\EditInvoiceTemplate::route('/{record}/edit'),
        ];
    }
}
