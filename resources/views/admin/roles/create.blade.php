@extends('layouts.app') @section('content')
<div class="container">
    <h3>Create New Role</h3>

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required
            />
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Permissions</label>
            @foreach($permissions as $permission)
            <div class="form-check">
                <input
                    type="checkbox"
                    class="form-check-input"
                    name="permissions[]"
                    value="{{ $permission->name }}"
                    id="perm_{{ $permission->id }}"
                />
                <label
                    class="form-check-label"
                    for="perm_{{ $permission->id }}"
                >
                    {{ ucfirst($permission->name) }}
                </label>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Create Role</button>
    </form>
</div>
@endsection
