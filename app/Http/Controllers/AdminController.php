<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', compact('users'));
    }
}
