<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageSentNotification extends Notification
{
    use Queueable;

    protected $message, $sender;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->preferences && $notifiable->preferences->notification_via) {
            //added the database string to always set it as default
            return explode(',', 'database,' . $notifiable->preferences()->notification_via);
        }
        return ['database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable)
    {

        return [
            "sender"=>$this->sender->name,
            "message"=>$this->message
        ];
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
