@extends('layouts.app')
@section('content')

<h4>{{ isset($task) ? 'Edit' : 'Create' }} Task - {{ $project->name }}</h4>

<form method="POST" action="{{ isset($task) 
    ? route('tasks.update', $task) 
    : route('projects.tasks.store', $project) }}">
    @csrf
    @if(isset($task)) @method('PUT') @endif

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" 
               value="{{ old('title', $task->title ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status_id" class="form-select">
            <option value="">-- Select Status --</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" 
                    {{ old('status_id', $task->status_id ?? '') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Tags</label>
        <select name="tags[]" multiple class="form-select">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"
                    @if(isset($task) && $task->tags->contains($tag->id)) selected @endif>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Assigned To</label>
        <select name="assigned_to" class="form-select">
            <option value="">-- None --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('assigned_to', $task->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control"
               value="{{ old('due_date', isset($task) ? $task->due_date : '') }}">
    </div>

    <button class="btn btn-success">
        {{ isset($task) ? 'Update' : 'Create' }} Task
    </button>
</form>

@endsection
