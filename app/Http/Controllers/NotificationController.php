<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;
use App\Models\User;
use App\Notifications\AdminMessageNotification; // <--- MAKE SURE THIS IS IMPORTED
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    // 1. Show Notifications Page (Admin)
public function index()
{
    // 1. Get the actual notifications list
    $notifications = Auth::user()->notifications()->paginate(10);

    // 2. Fetch Overdue Requests
    $overdueRequests = WorkOrder::where('due_date', '<', now())
                        ->where('status', '!=', 'Resolved')
                        ->with('assignee') // Added eager loading for performance
                        ->get();

    // 3. Fetch High Priority Requests (THIS WAS MISSING)
    $highPriorityRequests = WorkOrder::where('priority', 'High')
                        ->where('status', '!=', 'Resolved')
                        ->with('assignee') // Added eager loading for performance
                        ->get();

    // 4. Pass ALL variables to the view
    return view('admin.notifications.index', compact('notifications', 'overdueRequests', 'highPriorityRequests'));
}

    // 2. Mark a Notification as Read
    public function markAsRead($id)
{
    // 1. Find the notification belonging to the user
    $notification = Auth::user()->notifications()->find($id);

    // 2. Mark it as read if it exists
    if ($notification) {
        $notification->markAsRead();
    }

    // 3. RELOAD CURRENT PAGE (Do not redirect to the edit screen)
    return redirect()->back();
}

    // 3. Send a Message (Triggered from the Alerts Modal)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'work_order_id' => 'required|exists:work_orders,id', // Validate the hidden input
            'message' => 'required|string',
        ]);

        $employee = User::find($request->user_id);
        $workOrder = WorkOrder::find($request->work_order_id);

        // Send the actual notification class
        // This automatically saves to the DB with the correct 'type'
        $employee->notify(new AdminMessageNotification(
            $request->message,
            $workOrder->title,
            $workOrder->id
        ));

        return back()->with('success', 'Notification sent successfully to ' . $employee->name);
    }
}
