<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkOrder;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Start query from WorkOrder
        $query = WorkOrder::with(['user', 'assignee']);

        // 2. Filter by Search (ID, Title, User Name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter by Priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // 5. Get Results
        $requests = $query->latest()->paginate(10);

        // 6. Get Employees for the modal dropdown
        $employees = User::where('role', 'employee')->orderBy('name')->get();

        return view('admin.requests.index', compact('requests', 'employees'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate inputs
        $request->validate([
            'status' => 'required',
            'priority' => 'required',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        // Find and Update
        $workOrder = WorkOrder::findOrFail($id);

        $workOrder->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'due_date' => $request->due_date,
        ]);

        return back()->with('success', 'Request updated successfully.');
    }

    public function dashboard()
    {
        $orders = WorkOrder::latest()->get();

        $total = $orders->count();
        $resolved = $orders->where('status', 'Resolved')->count();
        $unresolved = $orders->whereIn('status', ['Pending', 'In Progress'])->count();

        $alerts = $orders->where('priority', 'High')
                         ->where('status', '!=', 'Resolved')
                         ->count();

        $employees = User::where('role', 'employee')->get();

        $chartStatus = [
            'resolved'   => $resolved,
            'pending'    => $orders->where('status', 'Pending')->count(),
            'inprogress' => $orders->where('status', 'In Progress')->count(),
        ];

        $categories = $orders->groupBy('category')->map->count();

        return view('admin.dashboard', compact(
            'orders', 'total', 'resolved', 'unresolved',
            'alerts', 'employees', 'chartStatus', 'categories'
        ));
    }

    public function reportsIndex(Request $request)
    {
        $query = WorkOrder::with(['user', 'assignee']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->latest()->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function printReport($id)
    {
        $order = WorkOrder::with(['user', 'assignee'])->findOrFail($id);
        return view('admin.reports.print', compact('order'));
    }

    public function previewReport(Request $request)
    {
        $request->validate([
            'selected_reports' => 'required|array',
            'selected_reports.*' => 'exists:work_orders,id',
        ], [
            'selected_reports.required' => 'Please select at least one report to generate a preview.'
        ]);

        $reports = WorkOrder::whereIn('id', $request->selected_reports)
                            ->with(['user', 'assignee'])
                            ->latest()
                            ->get();

        return view('admin.reports.preview', compact('reports'));
    }

    public function editStatus($id)
    {
        $workOrder = WorkOrder::findOrFail($id);
        $employees = User::where('role', 'employee')->get();

        // You must create a view at resources/views/admin/requests/edit.blade.php
        return view('admin.requests.edit', compact('workOrder', 'employees'));
    }

    public function alerts()
{
    // 1. Fetch Overdue: Not resolved, due date is in the past
    $overdueRequests = WorkOrder::where('status', '!=', 'Resolved')
        ->where('due_date', '<', Carbon::now())
        ->with('assignee') // Ensure you load the relationship
        ->get();

    // 2. Fetch High Priority: Not resolved, priority is High
    $highPriorityRequests = WorkOrder::where('status', '!=', 'Resolved')
        ->where('priority', 'High')
        ->with('assignee')
        ->get();

    return view('admin.alerts', compact('overdueRequests', 'highPriorityRequests'));
}
}
