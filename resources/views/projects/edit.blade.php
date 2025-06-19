@extends('layouts.app') @section('title', 'Edit Project') @section('content')
<h4>Edit Project</h4>

<form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input
            type="text"
            name="name"
            class="form-control"
            required
            value="{{ old('name', $project->name) }}"
        />
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea
            name="description"
            class="form-control"
            >{{ old('description', $project->description) }}</textarea
        >
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status_id" class="form-select">
            <option value="">-- Select Status --</option>
            @foreach($statuses as $status)
            <option value="{{ $status->id }}" {{ $project->
                status_id == $status->id ? 'selected' : '' }}>
                {{ $status->name }}
            </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
