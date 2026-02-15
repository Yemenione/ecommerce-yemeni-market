<?php

namespace App\Jobs;

use App\Models\MarketingTemplate;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscriber;
    public $template;

    /**
     * Create a new job instance.
     */
    public function __construct(NewsletterSubscriber $subscriber, MarketingTemplate $template)
    {
        $this->subscriber = $subscriber;
        $this->template = $template;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->subscriber->email;
        $subject = $this->template->subject;
        $content = $this->template->content;

        Mail::html($content, function ($message) use ($email, $subject) {
            $message->to($email)
                ->subject($subject);
        });
    }
}
