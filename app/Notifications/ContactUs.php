<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUs extends Notification
{
    use Queueable;
    public $message,$email,$name,$phone;
    /**
     * Create a new notification instance.
     */
    public function __construct($message,$email,$name,$phone)
    {
        $this->message = $message;
        $this->email   = $email;
        $this->name    = $name;
        $this->phone   = $phone;
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
            
                    ->line('New Contact query has been received in RSM')
                    ->line('Name  : '.$this->name)
                    ->line('Email : '.$this->email)
                    ->line('Phone : '.$this->phone)
                    ->line('Message : ')
                    ->line($this->message)
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
