<?php

namespace App\Notifications\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalNotification extends Notification
{
    use Queueable;
    public $job_id;
    /**
     * Create a new notification instance.
     */
    public function __construct( $job_id =0)
    {
        $this->job_id = $job_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->cc($notifiable->email_additional ? $notifiable->email_additional : [])
            ->subject('Employer Account Approval Notification From RSM.')
            ->greeting('Hello ' . $notifiable->firstname . ' ' . $notifiable->lastname)
            ->line('Welcome to ' . config('app.name', 'RSM'))
            ->line('Congratulations! Your employer account has been approved successfully by administator. You can login now by clicking on the button below')            
            ->action('Login', route('login'))
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
            'job_id' => $this->job_id
        ];
    }
}
