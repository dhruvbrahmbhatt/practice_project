@extends('layouts.app') @section('title', 'Tasks on ' . $date)
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Tasks for {{ $date }}</h3>

    @if($tasks->count())
    <div class="list-group">
        @foreach($tasks as $task)
        <div class="list-group-item">
            <h5 class="mb-1">{{ $task->title }}</h5>
            <p class="mb-1">{{ $task->description }}</p>
            <small class="text-muted"
                >Hours Spent: {{ $task->hours_spent }}</small
            >
            <div class="mt-2">
                <a
                    href="{{ route('tasks.edit', $task->id) }}"
                    class="btn btn-sm btn-warning"
                    >Edit</a
                >
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No tasks found for this date.</p>
    @endif
</div>
@endsection
