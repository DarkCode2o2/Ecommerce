<?php

namespace App\Livewire\Auth;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class LoginPage extends Component
{
    public $email; 
    public $password; 


    public function login() {
        $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => 'required|string',
        ]);

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended('/');
        } else {
            $this->addError('error', 'The provided credentials are incorrect.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
