@extends('layouts.app') @section('title', 'Create Group') @section('content')
<div class="container">
    <h3 class="mb-3">Create a New Group</h3>
    <form method="POST" action="{{ route('group.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                required
            />
        </div>

        <div class="mb-3">
            <label class="form-label">Select Members</label>
            <select name="members[]" class="form-select" multiple required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create Group</button>
    </form>
</div>
@endsection
