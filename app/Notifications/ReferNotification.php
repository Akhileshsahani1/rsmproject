<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferNotification extends Notification
{
    use Queueable;

    public $message,$job;

    /**
     * Create a new notification instance.
     */
    public function __construct($message,$job)
    {
        $this->message = $message;
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->subject('Your Friend Refer this Job to You.')
                ->line('Welcome to ' . config('app.name', 'RSM'))
                ->line($this->message)
                ->action('View Job', route('frontend.job.show',$this->job->id))
                ->line('Thank you for using ' . config('app.name', 'RSM'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
