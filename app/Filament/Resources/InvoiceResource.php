<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Invoice;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\UserAccountantResource\Pages\CashPaymentSlip;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'Payment Slip';

    protected static ?string $slug = 'payment-slips';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 12])->schema([

                    Select::make('invoice_template_id')
                    ->rules(['required', 'exists:invoice_templates,id'])
                    ->relationship('invoiceTemplate', 'title_ar')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 6,
                        'lg' => 6,
                    ]),

                    // user_id
                    Select::make('user_id')
                        ->rules(['required', 'exists:users,id'])
                        ->relationship('user', 'name')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // title
                    TextInput::make('title')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Title')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // date
                    DatePicker::make('date')
                        ->rules(['required', 'date'])
                        ->placeholder('Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // received_from
                    TextInput::make('received_from')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Received From')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // amount
                    TextInput::make('amount')
                        ->rules(['required', 'numeric'])
                        ->placeholder('Amount')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // amount_ar
                    TextInput::make('amount_ar')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Amount Ar')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // amount_en
                    TextInput::make('amount_en')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Amount En')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // dhs
                    TextInput::make('dhs')
                        ->rules(['required', 'numeric'])
                        ->placeholder('Dhs')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // fils
                    TextInput::make('fils')
                        ->rules(['required', 'numeric'])
                        ->placeholder('Fils')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // cheque_no
                    TextInput::make('cheque_no')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Cheque No')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // due_date
                    DatePicker::make('due_date')
                        ->rules(['required', 'date'])
                        ->placeholder('Due Date')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // bank
                    TextInput::make('bank')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Bank')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // account_no
                    TextInput::make('account_no')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Account No')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 6,
                            'lg' => 6,
                        ]),

                    // being
                    TextInput::make('being')
                        ->rules(['required', 'max:255', 'string'])
                        ->placeholder('Being')
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
                Tables\Columns\TextColumn::make('invoice_template_id')->label('Invoice Template'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('received_from'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // {record}/paymentSlip
                Action::make('create.payment')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->url(fn (Invoice $record) => InvoiceResource::getUrl('create.payment', $record)),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'create.payment' => CashPaymentSlip::route('/{record}/paymentSlip'),
        ];
    }
}
