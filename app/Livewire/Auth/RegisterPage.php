<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class RegisterPage extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function mount()
    {
        if (auth()->check()) {
            return redirect()->intended(route('home'));
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => \Illuminate\Support\Facades\Hash::make($this->password),
        ]);

        auth()->login($user);

        return redirect()->to(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
