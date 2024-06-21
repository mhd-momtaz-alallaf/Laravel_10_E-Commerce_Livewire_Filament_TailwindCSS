<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register | E-Commerce')] // Livewire Attribute for Changing the Default page title.

class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function save() // registering new users.
    {
        $this->validate([ // validating the credentials.
            'name'=> 'required|max:255',
            'email'=> 'required|email|unique:users|max:255',
            'password'=> 'required|min:6|max:255',
        ]);

        $user = User::create([ // creating a new user model with the validated credentials.
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> Hash::make($this->password),
        ]);

        auth()->login($user); // logging the new user in.

        return redirect()->intended(); // redirecting the user to the last visited page before the registration process.
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
