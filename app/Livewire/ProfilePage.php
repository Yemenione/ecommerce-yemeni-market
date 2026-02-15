<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Order;

class ProfilePage extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $birthday;
    public $avatar;
    public $current_avatar;
    
    public $activeTab = 'overview';
    
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->birthday = $user->birthday;
        $this->current_avatar = $user->avatar_url;
    }

    public function updateProfile()
    {
        $user = auth()->user();
        
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birthday' => 'nullable|date',
        ]);

        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
            $validatedData['avatar_url'] = $avatarPath;
            $this->current_avatar = $avatarPath;
        }

        $user->update($validatedData);

        session()->flash('success', __('Profile updated successfully.'));
    }

    public function updatePassword()
    {
        $user = auth()->user();
        
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', __('Password updated successfully.'));
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->take(5)->get();
        
        return view('livewire.profile-page', [
            'orders' => $orders,
        ]);
    }
}
