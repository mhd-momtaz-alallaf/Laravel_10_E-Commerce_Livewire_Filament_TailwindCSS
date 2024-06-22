<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Illuminate\Support\Str;

#[Title('Reset Password | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ResetPasswordPage extends Component
{
    public $token;

    #[Url] // livewire attribute to get the email from the route parameter from the reset password link.
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token){
        $this->token = $token; // initializing the token from the route parameter(/reset/{token}).
    }

    public function save() // reset the user password.
    {
        $this->validate([
            'token'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required|min:6|confirmed',
        ]);

        $status = Password::reset([
            'token'=> $this->token,
            'email'=> $this->email,
            'password'=> $this->password,
            'password_confirmation' => $this->password_confirmation,
        ],
        function(User $user, string $password) { // passing the user instance and the new password.
            $password = $this->password;
            $user->forceFill([
                'password' => Hash::make($password), // attaching the new password to the user.
            ])->setRememberToken(Str::random(60)); // setting a new remember token.
            $user->save(); // saving the changes.
        });
        
        return $status === Password::PASSWORD_RESET ? redirect(route('login')) : session()->flash('error', 'Something went wrong!');
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
