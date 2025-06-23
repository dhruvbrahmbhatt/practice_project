@extends('layouts.app') @section('content')
<div class="container">
    <h3>Log Task</h3>

    <form action="{{ route('task-logs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Select Task</label>
            <div class="input-group">
                <select name="task_id" class="form-select" required>
                    <option value="">-- Select Task --</option>
                    @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Hours Spent</label>
            <input
                type="number"
                name="hours_spent"
                class="form-control"
                step="0.1"
                required
            />
        </div>

        <div class="mb-3">
            <label>Log Date</label>
            <input type="date" name="log_date" class="form-control" required />
        </div>

        <div class="mb-3">
            <label>Description (optional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
