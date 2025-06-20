@extends('layouts.app') @section('content')
<h3>All Roles</h3>
<a href="{{ route('roles.create') }}" class="btn btn-primary mb-3"
    >➕ Create Role</a
>
@foreach($roles as $role)
<div class="card mb-2">
    <div class="card-body">
        <strong>{{ $role->name }}</strong
        ><br />
        Permissions: @foreach($role->permissions as $perm)
        <span class="badge bg-info text-dark">{{ $perm->name }}</span>
        @endforeach
    </div>
</div>
@endforeach @endsection
