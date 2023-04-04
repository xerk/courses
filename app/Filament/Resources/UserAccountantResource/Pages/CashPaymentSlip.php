<?php

namespace App\Filament\Resources\UserAccountantResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Columns\Layout\Grid;
use App\Filament\Resources\UserAccountantResource;

class CashPaymentSlip extends Page
{
    protected static string $resource = UserAccountantResource::class;

    protected static string $view = 'filament.resources.user-accountant-resource.pages.cash-payment-slip';



    public function mount()
    {
        // $this->record = $this->resolveRecord($record);
        return $user ='hi';
    }

    public function submit()
    {
        // $this->form->getState();

        // $state = array_filter([
        //     'name' => $this->name,
        //     'email' => $this->email,
        // ]);

        // $user = auth()->user();

        // $user->update($state);


        // $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        // $this->notify('success', 'Your profile has been updated.');
    }

    public function print() {
        $this->dispatchBrowserEvent('print');
    }




    protected function getFormSchema(): array
    {
        return [
            Section::make('General')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->required(),
                ]),
            ];
    }
}
