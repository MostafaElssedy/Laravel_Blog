<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Str;

class NewsletterForm extends Component
{
    public $email = '';
    public $subscribed = false;

    protected $rules = [
        'email' => 'required|email|max:255|unique:subscribers,email',
    ];

    protected $messages = [
        'email.required' => 'Please enter your email address.',
        'email.email'    => 'Please enter a valid email address.',
        'email.unique'   => 'You are already subscribed to our newsletter.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function subscribe()
    {
        $this->validate();

        $subscriber = Subscriber::create([
            'email'  => strtolower(trim($this->email)),
            'token'  => Str::random(64),
            'status' => true,
        ]);

        // Optional welcome email
        try {
            if (class_exists(\App\Helpers\CMail::class)) {
                $blogSettings = \App\Models\GeneralSetting::getSettings();
                $blogName = optional($blogSettings)->blog_name ?? 'LaraBlog';

                $body = view('email-templates.welcome-newsletter', [
                    'subscriber' => $subscriber,
                    'blogName'   => $blogName,
                    'exploreUrl' => url('/'),
                ])->render();

                $mailConfig = [
                    'recipient_address' => $subscriber->email,
                    'recipient_name'    => 'Valued Reader',
                    'subject'           => 'Welcome to the ' . $blogName . ' Newsletter! 🎉',
                    'body'              => $body,
                ];
                \App\Helpers\CMail::send($mailConfig);
            }
        } catch (\Throwable $e) {
            // Silently ignore mail failures so user experience is not disrupted
        }

        $this->reset('email');
        $this->subscribed = true;

        $this->dispatch('showToast', [
            'message' => '🎉 Successfully subscribed! Welcome to our newsletter.',
            'type'    => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
