<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewIncident extends Notification
{
    use Queueable;

    public $incident;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($incident)
    {
        $this->incident = $incident;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'incident_id' => $this->incident->id,
            'title' => $this->incident->title,
            'user_name' => $this->incident->user->name,
            'priority' => $this->incident->priority,
            'message' => 'Un nouvel incident a été signalé : ' . $this->incident->title,
            'link' => route('incidents.index'),
        ];
    }
}
