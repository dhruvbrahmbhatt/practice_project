@extends('layouts.app') @section('content')
<div class="container">
    <h3>Admin Dashboard – User Task Overview</h3>

    @foreach($users as $user)
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            {{ $user->name }} ({{ $user->email }})
            <span
                class="badge bg-info"
                >{{ $user->getRoleNames()->join(', ') }}</span
            >
        </div>
        <div class="card-body">
            <p><strong>Performance:</strong> {{ $user->performance }}%</p>

            @if($user->tasks->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name ?? 'N/A' }}</td>
                        <td>{{ $task->status->name ?? 'N/A' }}</td>
                        <td>{{ $task->due_date ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No tasks assigned.</p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
