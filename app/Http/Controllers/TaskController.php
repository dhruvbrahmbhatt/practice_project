<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request, Project $project)
    {
        return view('tasks.create', [
            'project' => $project,
            'statuses' => Status::all(),
            'users' => User::all(),
            'tags' => Tag::all(),
        ]);
    }
    public function store(Request $request, Project $project)
    {
        $task = $project->tasks()->create($request->only([
            'title',
            'description',
            'status_id',
            'assigned_to',
            'due_date'
        ]));

        $task->tags()->sync($request->tags); // Attach tags

        return redirect()->route('projects.show', $project)->with('success', 'Task created');
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->only([
            'title',
            'description',
            'status_id',
            'assigned_to',
            'due_date'
        ]));

        $task->tags()->sync($request->tags);

        return redirect()->route('projects.show', $task->project)->with('success', 'Task updated');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'status', 'tags', 'assignee']);
        return view('tasks.show', compact('task'));
    }
}
