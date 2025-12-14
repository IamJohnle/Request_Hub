<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'title',
    'category',
    'description',
    'priority',
    'status',
    'assigned_to',
    'due_date', // <--- YOU MUST ADD THIS LINE
    ];

    protected $casts = [
        'due_date' => 'date', // <--- Casts to Carbon instance
    ];

    // The user who CREATED the request
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The employee/admin ASSIGNED to fix the request
    // <--- 2. IMPORTANT: Add this function to fix the error
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
