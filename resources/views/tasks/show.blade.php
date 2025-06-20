@extends('layouts.app') @section('content')
<div class="container">
    <h3>{{ $task->title }}</h3>
    <p>
        <strong>Description:</strong><br />
        {{ $task->description ?? '—' }}
    </p>

    <p><strong>Status:</strong> {{ $task->status->name ?? 'N/A' }}</p>
    <p><strong>Project:</strong> {{ $task->project->name }}</p>
    <p><strong>Due Date:</strong> {{ $task->due_date ?? 'N/A' }}</p>
    <p>
        <strong>Assigned To:</strong>
        {{ $task->assignee->name ?? 'Unassigned' }}
    </p>

    <p>
        <strong>Tags:</strong><br />
        @forelse($task->tags as $tag)
        <span class="badge bg-secondary">{{ $tag->name }}</span>
        @empty
        <span class="text-muted">No tags</span>
        @endforelse
    </p>

    <a
        href="{{ route('projects.kanban', $task->project) }}"
        class="btn btn-outline-primary"
        >⬅ Back to Kanban</a
    >
</div>
@endsection
