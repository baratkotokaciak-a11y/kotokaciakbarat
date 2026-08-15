<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->canViewActivityLogs()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = ActivityLog::with('user')->latest();
        
        // Apply filters
        $filters = [
            'action' => $request->action,
            'user_id' => $request->user_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'search' => $request->search,
        ];
        
        $query->filter($filters);
        
        $activityLogs = $query->paginate(50);
        $users = User::orderBy('name')->get();
        
        // Get action types for filter
        $actionTypes = ActivityLog::select('action')->distinct()->pluck('action');
        
        return view('activity-logs.index', compact('activityLogs', 'users', 'actionTypes', 'filters'));
    }
    
    public function show(ActivityLog $activityLog)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->canViewActivityLogs()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $activityLog->load('user');
        
        return view('activity-logs.show', compact('activityLog'));
    }
    
    public function destroy(ActivityLog $activityLog)
    {
        if (!Auth::check() || !Auth::user()->canDeleteActivityLogs()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus log aktivitas.');
        }
        
        $activityLog->delete();
        
        return back()->with('success', 'Log aktivitas berhasil dihapus.');
    }
}
