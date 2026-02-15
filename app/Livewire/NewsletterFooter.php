<?php

namespace App\Livewire;

use Livewire\Component;

class NewsletterFooter extends Component
{
    public $email = '';

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        \App\Models\NewsletterSubscriber::create([
            'email' => $this->email,
            'is_active' => true,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\NewsletterSubscriptionConfirmed());
        } catch (\Exception $e) {
            // Log error but don't stop the user experience
            \Illuminate\Support\Facades\Log::error('Newsletter confirmation email failed: ' . $e->getMessage());
        }

        $this->email = '';

        session()->flash('success', __('Thank you for subscribing to our newsletter!'));
    }

    public function render()
    {
        return view('livewire.newsletter-footer');
    }
}
