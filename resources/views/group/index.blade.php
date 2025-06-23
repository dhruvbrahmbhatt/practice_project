@extends('layouts.app')
@section('title', 'Group & User Chat')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar: Groups and Users -->
        <div class="col-md-3 border-end" style="height: 100vh; overflow-y: auto">
            <h5 class="mt-3">Groups</h5>
            <div class="list-group mb-4">
                <a href="{{ route('group.create') }}" class="list-group-item list-group-item-action">
                    + Create Group
                </a>
                @if(isset($groups) && $groups->count())
                    @foreach($groups as $group)
                        <a href="{{ route('group.chat', $group->id) }}" class="list-group-item list-group-item-action">
                            {{ $group->name }}
                        </a>
                    @endforeach
                @else
                    <div class="list-group-item">No groups found.</div>
                @endif
            </div>

            <h5>Users</h5>
            <div class="list-group">
                @if(isset($users) && $users->count())
                    @foreach($users as $user)
                        <a href="{{ route('chat.with', $user->id) }}" class="list-group-item list-group-item-action">
                            {{ $user->name }}
                        </a>
                    @endforeach
                @else
                    <div class="list-group-item">No users found.</div>
                @endif
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-9">
            @isset($activeGroup)
                <div class="card mt-3">
                    <div class="card-header">Group: {{ $activeGroup->name }}</div>
                    <div class="card-body" style="height: 500px; overflow-y: scroll">
                        @if($messages && $messages->count())
                            @foreach($messages as $message)
                                @php
                                    $isOwn = $message->from_user_id === Auth::id();
                                    $sender = $activeGroup->users->where('id', $message->from_user_id)->first();
                                    $senderName = $isOwn ? 'You' : optional($sender)->name;
                                @endphp
                                <div class="d-flex {{ $isOwn ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                                    <div class="p-2 rounded {{ $isOwn ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 70%">
                                        <strong>{{ $senderName }}:</strong>
                                        <div>{{ $message->message }}</div>
                                        @if($message->image)
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $message->image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $message->image) }}" style="max-width: 100px; border-radius: 5px;" />
                                                </a>
                                            </div>
                                        @endif
                                        <div class="text-muted small text-end">
                                            {{ $message->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No messages yet.</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('group.send', $activeGroup->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="message" class="form-control" placeholder="Type your message" />
                                <input type="file" name="image" class="form-control" />
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-3">
                    Select a group or user to start chatting.
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection
