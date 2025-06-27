// resources/views/tasklogs/edit.blade.php @extends('layouts.app')
@section('title', 'Edit Task Log') @section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Task Log</h3>

    <form method="POST" action="{{ route('tasks.update', $taskLog->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Task</label>
            <input
                type="text"
                name="title"
                class="form-control"
                value="{{ $taskLog->task->title }}"
                readonly
            />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea
                name="description"
                id="description"
                class="form-control"
                rows="4"
                required
                >{{ old('description', $taskLog->description) }}</textarea
            >
        </div>

        <div class="mb-3">
            <label for="hours_spent" class="form-label">Hours Spent</label>
            <input
                type="number"
                name="hours_spent"
                id="hours_spent"
                class="form-control"
                step="0.1"
                value="{{ old('hours_spent', $taskLog->hours_spent) }}"
                required
            />
        </div>

        <div class="mb-3">
            <label for="log_date" class="form-label">Log Date</label>
            <input
                type="date"
                name="log_date"
                id="log_date"
                class="form-control"
                value="{{ old('log_date', $taskLog->log_date) }}"
                required
            />
        </div>

        <button type="submit" class="btn btn-success">Update Log</button>
    </form>
</div>
@endsection
