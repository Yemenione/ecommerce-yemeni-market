<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class ContactPage extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:3',
        'message' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->reset();
        session()->flash('success', 'Your message has been sent successfully. We will contact you soon.');
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}
