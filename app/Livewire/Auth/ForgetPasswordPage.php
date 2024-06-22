<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Forget Password | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class ForgetPasswordPage extends Component
{
    public $email;

    public function save() // Sending the reset Password link to the email address of the user.
    {
        $this->validate([ // validating the email.
            'email'=> 'required|email|exists:users,email|max:255',
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link has been sent to your email address!');
            $this->email = '';
        }
    }

    public function render()
    {
        return view('livewire.auth.forget-password-page');
    }
}
