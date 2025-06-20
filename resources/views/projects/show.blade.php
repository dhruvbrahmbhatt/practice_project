@extends('layouts.app') @section('content')
<div class="container">
    <h2>Project: {{ $project->name }}</h2>
    <p>{{ $project->description }}</p>

    <h4>Tasks</h4>
    <ul>
        @foreach($statuses as $status)
        <h4>{{ $status->name }}</h4>

        @php $tasksForStatus = $project->tasks->where('status_id', $status->id);
        @endphp @foreach($tasksForStatus as $task)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $task->title }}</strong>
                @foreach($task->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        @endforeach @endforeach
    </ul>

    <a
        href="{{ route('projects.kanban', $project) }}"
        class="btn btn-outline-primary mt-3"
    >
        View Kanban Board
    </a>
</div>
@endsection
