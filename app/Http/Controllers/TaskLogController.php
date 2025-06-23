<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskLogController extends Controller
{
    public function index()
    {
        $logs = TaskLog::with('task')
            ->where('user_id', Auth::id())
            ->orderBy('log_date', 'desc')
            ->get();

        return view('task_logs.index', compact('logs'));
    }

    public function create()
    {
        $tasks = Task::all(); // For dropdown
        return view('task_logs.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'hours_spent' => 'required|numeric|min:0.1',
            'log_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        // dd($request->task_id);
        TaskLog::create([
            'user_id' => Auth::id(),
            'task_id' => $request->task_id,
            'hours_spent' => $request->hours_spent,
            'description' => $request->description,
            'log_date' => $request->log_date,
        ]);
        return redirect()->route('task-logs.index')->with('success', 'Task logged successfully!');
    }
}
