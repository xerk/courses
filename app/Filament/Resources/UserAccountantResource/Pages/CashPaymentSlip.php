<?php

namespace App\Filament\Resources\UserAccountantResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Layout\Grid;
use App\Filament\Resources\UserAccountantResource;

class CashPaymentSlip extends Page
{
    protected static string $resource = UserAccountantResource::class;

    protected static string $view = 'filament.resources.user-accountant-resource.pages.cash-payment-slip';

    public $name;

    public $email;

    public $current_password;

    public $new_password;

    public $new_password_confirmation;

    public function mount()
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function submit()
    {
        $this->form->getState();

        $state = array_filter([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user = auth()->user();

        $user->update($state);


        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->notify('success', 'Your profile has been updated.');
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
