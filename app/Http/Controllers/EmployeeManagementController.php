<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
class EmployeeManagementController extends Controller
{
    // 1. LIST EMPLOYEES
    public function index(Request $request)
    {
        $query = User::query();

        // Simple Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $employees = $query->latest()->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    // 2. SHOW CREATE FORM
    public function create()
    {
        return view('admin.employees.create');
    }

    // 3. STORE NEW EMPLOYEE
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,employee'], // Ensure valid roles
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    // 4. SHOW EDIT FORM
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    // 5. UPDATE EMPLOYEE
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$id],
            'role' => ['required', 'in:admin,employee'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Nullable means optional
        ]);

        // Update basic info
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role = $request->role;

        // Update password only if provided
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }

        $employee->save();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    // 6. DELETE EMPLOYEE
    public function destroy($id)
    {
        // Prevent deleting yourself
        if ($id == Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee removed successfully.');
    }
}
