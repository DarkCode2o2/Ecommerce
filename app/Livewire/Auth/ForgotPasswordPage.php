<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forgot Password')]
class ForgotPasswordPage extends Component
{

    public $email; 

    public function save() {
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email'
        ]);

        $state = Password::sendResetLink(['email' => $this->email]);

        if($state === Password::RESET_LINK_SENT) {
            Session()->flash('success', 'Reset password link has been sent to your email!');
            $this->email = '';
        }

    }

    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
