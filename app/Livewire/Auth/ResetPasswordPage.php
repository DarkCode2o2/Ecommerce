<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title("Reset Password")]
class ResetPasswordPage extends Component
{
    #[Url]
    public $email;
    public $password;
    public $password_confirmation;
    public $token;

    public function mount($token) {
        $this->token = $token;
    }

    public function save() {
        $this->validate([
            'token' => 'required', 
            'email' => 'required|email', 
            'password' => 'required|confirmed'
        ]);

        $status = Password::reset([
            'token' => $this->token, 
            'email' => $this->email, 
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ], 
            function(User $user, string $password) {
                $password = $this->password;
                $user->forceFill([
                    'password' => Hash::make($password), 
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(New PasswordReset($user));
            }
        );
        if($status == Password::PASSWORD_RESET) {
            LivewireAlert::title('Success!')
                ->text('Password has been updated Successfully!')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
            return redirect('/login');
        }else {
            session()->flash('error', 'Something went wrong');
        }

        return redirect()->back();
    } 

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
