@extends('layouts.app') @section('title', 'My Task Logs') @section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>My Logged Tasks</h3>
        <a href="{{ route('task-logs.create') }}" class="btn btn-primary">
            + Log New Task
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session("success") }}
    </div>
    @endif @if($logs->count())
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Task</th>
                    <th>Hours Spent</th>
                    <th>Description</th>
                    <th>Logged At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($log->log_date)->format('d M Y') }}
                    </td>
                    <td>{{ $log->task->title ?? '-' }}</td>
                    <td>{{ $log->hours_spent }}</td>
                    <td>{{ $log->description ?? '-' }}</td>
                    <td>{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">You haven't logged any tasks yet.</div>
    @endif
</div>
@endsection
