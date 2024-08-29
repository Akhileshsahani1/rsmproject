<?php

namespace App\Notifications\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplication extends Notification
{
    use Queueable;

    public $user, $jobid;
    /**
     * Create a new notification instance.
     */

    public function __construct($user, $jobid)
    {
        $this->user  = $user;
        $this->jobid = $jobid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            
                'employee_id'    => $this->user['id'],
                'name' => $this->user['firstname']." ".$this->user['lastname'],
                'email'          => $this->user['email'],
                'job_id'         => $this->jobid,
    
        ];
    }
}
