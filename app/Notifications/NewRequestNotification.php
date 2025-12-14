<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewRequestNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $link;

    // 1. Pass data into the constructor
    public function __construct($title, $message, $link = '#')
    {
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
    }

    // 2. Specify we want to store this in the Database
    public function via($notifiable)
    {
        return ['database'];
    }

    // 3. Define the data array that gets saved
    public function toArray($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'link'    => $this->link,
            // 'icon' => 'optional-icon-class'
        ];
    }
}
