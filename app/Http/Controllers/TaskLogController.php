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

    public function edit(TaskLog $taskLog)
    {
        return view('task_logs.edit', compact('taskLog'));
    }
    public function update(Request $request, TaskLog $tasklog)
    {
        try {
            $request->validate([
                'description' => 'required|string',
                'hours_spent' => 'required|numeric|min:0',
                'log_date' => 'required|date',
            ]);

            $tasklog->update($request->only('description', 'hours_spent', 'log_date'));

            return redirect()->route('tasks.byDate', $request->log_date)
                ->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }


    public function calendar()
    {
        // dd(TaskLog::all());
        $calendarTasks = TaskLog::all()->map(function ($task) {
            return [
                'title' => $this->getTaskTitle($task->task_id) . ' (' . $task->hours_spent . ' hrs)',
                'start' => $task->log_date, // Ensure date format is YYYY-MM-DD
                'allDay' => true
            ];
        });

        return view('task_logs.calendar', compact('calendarTasks'));
    }

    public function listByDate($date)
    {
        $tasks = TaskLog::whereDate('log_date', $date)->get(); // assumes 'date' is the field name
        return view('task_logs.bydate', compact('tasks', 'date'));
    }

    public function getTaskTitle($id)
    {
        $taskData = Task::select('title')->where('id', $id)->first();
        return $taskData->title;
    }
}
