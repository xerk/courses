<?php

namespace App\Filament\Resources\AssigmentResource\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AssigmentResource;
use App\Mail\AssignmentNotfiy;

class EditAssigment extends EditRecord
{
    protected static string $resource = AssigmentResource::class;

    public function edit(): void
    {
    }

    protected function afterSave()
    {
        $users = User::find($this->data['users']);
        foreach ($users as $user) {
            Mail::to($user->email)->send(new AssignmentNotfiy($this->data, $user));
        }
        // if ()
        // Runs after the record is deleted.
    }
}
