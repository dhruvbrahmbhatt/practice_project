@extends('layouts.app') @section('title', $group->name) @section('content')
<div class="container">
    <h3 class="mb-3">Group: {{ $group->name }}</h3>

    <div class="border p-3 mb-3" style="height: 300px; overflow-y: scroll">
        @foreach($messages as $message) @php $isOwn = $message->from_user_id ===
        Auth::id(); @endphp
        <div
            class="d-flex {{
                $isOwn ? 'justify-content-end' : 'justify-content-start'
            }} mb-2"
        >
            <div
                class="p-2 rounded {{
                    $isOwn ? 'bg-primary text-white' : 'bg-light text-dark'
                }}"
                style="max-width: 70%"
            >
                <strong>
                    {{ $isOwn ? 'You' : optional($group->users->find($message->from_user_id))->name


                    }}:
                </strong>
                <div>{{ $message->message }}</div>

                {{-- Optional image preview --}}
                @if($message->image)
                <div class="mt-2">
                    <a
                        href="{{ asset('storage/' . $message->image) }}"
                        target="_blank"
                    >
                        <img
                            src="{{ asset('storage/' . $message->image) }}"
                            alt="image"
                            style="max-width: 100px; border-radius: 5px"
                        />
                    </a>
                </div>
                @endif

                <div class="text-muted small text-end">
                    {{ $message->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <form
        action="{{ route('group.send', $group->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="input-group">
            <input
                type="text"
                name="message"
                class="form-control"
                placeholder="Type your message"
            />
            <input type="file" name="image" class="form-control" />
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div>
@endsection
