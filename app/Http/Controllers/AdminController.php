<?php

namespace App\Http\Controllers;

use App\Models\TaskLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with(['roles', 'tasks.project', 'tasks.status'])->get();

        // Calculate task performance per user
        $users = $users->map(function ($user) {
            $totalTasks = $user->tasks->count();
            $completedTasks = $user->tasks->where('status.name', 'Done')->count();
            $user->performance = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            return $user;
        });

        $logs = TaskLog::selectRaw('log_date, SUM(hours_spent) as total_hours')
            ->groupBy('log_date')
            ->orderBy('log_date')
            ->get();

        $labels = $logs->pluck('log_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->toArray();
        $data = $logs->pluck('total_hours')->toArray();

        return view('admin.dashboard', compact('users', 'labels', 'data'));
    }
}
