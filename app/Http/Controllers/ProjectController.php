<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('status')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view('projects.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        $statuses = Status::all();
        return view('projects.edit', compact('project', 'statuses'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
        ]);

        $project->update($request->only('name', 'description', 'status_id'));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }


    public function show(Project $project)
    {
        $project->load(['tasks.tags', 'tasks.status', 'tasks.assignee']); // optional

        $statuses = Status::all(); // ✅ Add this line

        return view('projects.show', compact('project', 'statuses'));
    }

    public function kanban(Project $project)
    {
        $project->load(['tasks.status', 'tasks.tags', 'tasks.assignee']);
        $statuses = Status::all();

        // Calculate progress
        $totalTasks = $project->tasks->count();
        $doneStatus = Status::where('name', 'Done')->first();
        $doneTasks = $project->tasks->where('status_id', $doneStatus?->id)->count();
        $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;

        return view('projects.kanban', compact('project', 'statuses', 'progress'));
    }
}
