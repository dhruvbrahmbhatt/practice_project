@extends('layouts.app') @section('title', 'My Groups') @section('content')
<div class="container">
    <h3 class="mb-3">My Groups</h3>
    <a href="{{ route('group.create') }}" class="btn btn-primary mb-3"
        >+ Create Group</a
    >

    @if(isset($groups) && $groups->count())
    <ul class="list-group">
        @foreach($groups as $group)
        <li
            class="list-group-item d-flex justify-content-between align-items-center"
        >
            {{ $group->name }}
            <a
                href="{{ route('group.chat', $group->id) }}"
                class="btn btn-sm btn-outline-primary"
                >Open Chat</a
            >
        </li>
        @endforeach
    </ul>
    @else
    <p>No groups found.</p>
    @endif
</div>
@endsection
