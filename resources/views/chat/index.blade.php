@extends('layouts.app') @section('title', 'Chat Users') @section('content')
<div class="container">
    <h3 class="mb-4">💬 Select a user to chat with:</h3>

    <div class="row">
        @foreach($users as $user)
        <div class="col-md-6 mb-3">
            <a
                href="{{ route('chat.with', $user->id) }}"
                class="text-decoration-none text-dark"
            >
                <div class="card shadow-sm">
                    <div
                        class="card-body d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <h5 class="mb-1">{{ $user->name }}</h5>

                            @php $lastMessage =
                            \App\Models\Message::where(function ($q) use ($user)
                            { $q->where('from_user_id', auth()->id())
                            ->where('to_user_id', $user->id); })
                            ->orWhere(function ($q) use ($user) {
                            $q->where('from_user_id', $user->id)
                            ->where('to_user_id', auth()->id()); })
                            ->orderBy('created_at', 'desc') ->first();
                            $unreadCount =
                            \App\Models\Message::where('from_user_id',
                            $user->id) ->where('to_user_id', auth()->id())
                            ->whereNull('read_at') ->count(); @endphp
                            @if($lastMessage)
                            <small class="text-muted">
                                <strong
                                    >{{ $lastMessage->from_user_id === auth()->id() ? 'You:' : $user->name . ':' }}</strong
                                >
                                {{ \Illuminate\Support\Str::limit($lastMessage->message, 40) }}
                            </small>
                            @else
                            <small class="text-muted">No messages yet</small>
                            @endif
                        </div>

                        @if($unreadCount > 0)
                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
