<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WorkOrderStatusUpdated extends Notification
{
    use Queueable;

    protected $workOrder;

    public function __construct($workOrder)
    {
        $this->workOrder = $workOrder;
    }

    public function via($notifiable)
    {
        return ['database']; // Important: Store in DB
    }

    public function toArray($notifiable)
    {
        return [
            // These keys must match what you use in your Blade file: $notif->data['...']
            'title' => 'Request Updated',
            'message' => 'Your request #' . $this->workOrder->id . ' is now ' . $this->workOrder->status,
            // Provide the link for the NotificationController to redirect to
            'link' => route('employee.history'),
        ];
    }
}
