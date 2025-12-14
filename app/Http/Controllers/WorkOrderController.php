<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import this
use App\Notifications\HighPriorityWorkOrder; // Import this
use Illuminate\Support\Facades\Notification; // Import this
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewRequestNotification;

class WorkOrderController extends Controller
{
    // 1. EMPLOYEE DASHBOARD
    public function dashboard() {
    $user = Auth::user();

    $notifications = $user->notifications()
        ->latest()
        ->take(5)
        ->get();

    $unreadCount = $user->unreadNotifications()->count();

    $stats = [
        'total'       => $user->workOrders()->count(),
        'pending'     => $user->workOrders()->where('status', 'Pending')->count(),
        'in_progress' => $user->workOrders()->where('status', 'In Progress')->count(),
        'resolved'    => $user->workOrders()->where('status', 'Resolved')->count(),
    ];

    $recentActivity = $user->workOrders()->latest('updated_at')->take(5)->get();

    return view('employee.dashboard', compact('stats', 'recentActivity', 'notifications', 'unreadCount'));
}


    public function history() {

    // OLD: $requests = Auth::user()->workOrders()->latest()->get();

    // NEW: Use paginate(10) instead of get()
    $requests = Auth::user()->workOrders()->latest()->paginate(10);

    return view('employee.history', compact('requests'));

    }

    public function create() {
        return view('employee.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'description' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => 'nullable|date|after:today',
        ]);

        // 1. Create the Order
        $workOrder = Auth::user()->workOrders()->create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Pending',
            'due_date' => $request->input('due_date'),
        ]);

        // 2. NOTIFY ADMINS
        // Find the first admin (or all admins)
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            // Pass the URL where the ADMIN sees the request
            // Note: Ensure the route 'admin.edit' exists in web.php
            $targetUrl = route('admin.edit', $workOrder->id);

            $admin->notify(new NewRequestNotification(
                'New Request Received',
                'Employee ' . Auth::user()->name . ' has submitted a ' . $request->priority . ' priority request.',
                $targetUrl
            ));
        }

    // OPTION B: Notify all Admins
    // $admins = User::where('role', 'admin')->get();
    // Notification::send($admins, new NewRequestNotification(...));

    return redirect()->route('employee.dashboard')->with('success', 'Work order submitted!');
}
// Inside WorkOrderController class...

public function updateRequest(Request $request, $id) {
    $workOrder = Auth::user()->workOrders()->findOrFail($id);

    if($workOrder->status !== 'Pending') {
        return back()->with('error', 'Cannot edit request that is already processed.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required',
        'priority' => 'required|in:Low,Medium,High',
        'description' => 'required',
        'due_date' => 'nullable|date|after_or_equal:today',
    ]);

    $workOrder->update($request->only(['title', 'category', 'priority', 'description', 'due_date']));

    return back()->with('success', 'Request updated successfully.');
}

public function destroyRequest($id) {
    $workOrder = Auth::user()->workOrders()->findOrFail($id);

    if($workOrder->status !== 'Pending') {
        return back()->with('error', 'Cannot delete request that is already processed.');
    }

    $workOrder->delete();

    return back()->with('success', 'Request deleted successfully.');
}



}
