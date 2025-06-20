@extends('layouts.app') @section('content')
<h3>Kanban Board – {{ $project->name }}</h3>

<a
    href="{{ route('projects.tasks.create', $project) }}"
    class="btn btn-success mb-3"
>
    ➕ Create Task
</a>

<div class="row">
    @foreach($statuses as $status)
    <div class="col-md-4">
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">
                {{ $status->name }}
            </div>
            <div
                class="card-body"
                style="min-height: 200px; background: #f9f9f9"
            >
                @php $tasksForStatus = $project->tasks->where('status_id',
                $status->id); @endphp @forelse($tasksForStatus as $task)
                <a
                    href="{{ route('tasks.show', $task) }}"
                    class="text-decoration-none text-dark"
                >
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body p-2">
                            <strong>{{ $task->title }}</strong
                            ><br />
                            <small>Due: {{ $task->due_date ?? 'N/A' }}</small
                            ><br />
                            @foreach($task->tags as $tag)
                            <span
                                class="badge bg-secondary"
                                >{{ $tag->name }}</span
                            >
                            @endforeach
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-muted">No tasks</p>
                @endforelse
            </div>
        </div>
    </div>
    @endforeach
    <div class="mb-3">
        <label><strong>Project Progress:</strong> {{ $progress }}%</label>
        <div class="progress" style="height: 20px">
            <div
                class="progress-bar bg-success"
                role="progressbar"
                style="width: {{ $progress }}%;"
                aria-valuenow="{{ $progress }}"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                {{ $progress }}%
            </div>
        </div>
    </div>
</div>
@endsection
