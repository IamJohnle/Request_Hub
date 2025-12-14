<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminMessageNotification extends Notification
{
    use Queueable;

    public $message;
    public $workOrderTitle;
    public $workOrderId;

    public function __construct($message, $workOrderTitle, $workOrderId)
    {
        $this->message = $message;
        $this->workOrderTitle = $workOrderTitle;
        $this->workOrderId = $workOrderId;
    }

    public function via($notifiable)
    {
        return ['database']; // Stores in the notifications table
    }

    public function toArray($notifiable)
    {
        return [
            'work_order_id' => $this->workOrderId,
            'title' => 'Message from Admin', // The Bold Text
            'message' => $this->message,     // The content you typed in the modal
            'url' => route('employee.history'), // Where clicking sends the employee
        ];
    }
}
