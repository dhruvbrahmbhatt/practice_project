@extends('layouts.app') @section('content')
<div class="container mt-4">
    <h2 class="mb-3">Project: {{ $project->name }}</h2>

    <div class="mb-4">
        <p><strong>Description:</strong> {{ $project->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($project->status->name) }}</p>
    </div>

    <h4 class="mb-3">Tasks</h4>

    @forelse($statuses as $status) @php $tasksForStatus =
    $project->tasks->where('status_id', $status->id); @endphp
    @if($tasksForStatus->count())
    <div class="mb-4">
        <h5 class="text-primary">{{ $status->name }}</h5>
        @foreach($tasksForStatus as $task)
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="card-title mb-1">
                    <a
                        href="{{ route('tasks.show', $task->id) }}"
                        class="text-decoration-none text-dark"
                    >
                        {{ $task->title }}
                    </a>
                </h6>
                <p class="card-text small text-muted">
                    {{ Str::limit($task->description, 100) }}
                </p>
                <div>
                    @foreach($task->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="mt-2">
                    <a
                        href="{{ route('tasks.edit', $task->id) }}"
                        class="btn btn-sm btn-warning"
                        >Edit</a
                    >
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif @empty
    <p>No statuses or tasks found.</p>
    @endforelse

    <a
        href="{{ route('projects.kanban', $project) }}"
        class="btn btn-outline-primary mt-3"
    >
        View Kanban Board
    </a>
</div>
@endsection
