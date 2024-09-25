<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class LoginPage extends Component
{
    public $email;
    public $password;

    public function save() // logging the users in.
    {
        $this->validate([ // validating the credentials.
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|min:6|max:255',
        ]);

        if (!auth()->attempt(['email' => $this->email, 'password' => $this->password])) { // storing a session error message if the user credentials is invalid.
            session()->flash('error', 'Invalid Credentials');
            return;
        }

        return redirect()->intended(); // redirecting the user to the last visited page before the login process.
    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
