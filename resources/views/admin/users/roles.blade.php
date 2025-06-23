@extends('layouts.app') @section('content')
<h3>User Role Management</h3>
@foreach($users as $user)
<form
    method="POST"
    action="{{ route('users.roles.update', $user) }}"
    class="mb-3"
>
    @csrf
    <div class="card">
        <div class="card-body">
            <strong>{{ $user->name }} ({{ $user->email }})</strong><br />
            <select name="roles[]" multiple class="form-select mt-2">
                @foreach($roles as $role)
                <option value="{{ $role->name }}" @if($user->
                    hasRole($role->name)) selected @endif>
                    {{ ucfirst($role->name) }}
                </option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-success mt-2">Update Roles</button>
        </div>
    </div>
</form>
@endforeach @endsection
