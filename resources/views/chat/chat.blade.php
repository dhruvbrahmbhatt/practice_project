@extends('layouts.app') @section('title', 'Chat with ' . $user->name)
@section('content')
<div class="container py-4">
    <h3 class="mb-3">Chat with {{ $user->name }}</h3>

    <div class="border p-3 mb-3" style="height: 300px; overflow-y: auto">
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
                <strong>{{ $isOwn ? 'You' : $user->name }}:</strong>
                @if ($message->message)
                <div>{{ $message->message }}</div>
                @endif @if ($message->image)
                <div class="mt-2">
                    <img
                        src="{{ asset('storage/' . $message->image) }}"
                        alt="Image"
                        class="img-thumbnail"
                        style="max-height: 150px; cursor: pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#imageModal{{ $message->id }}"
                    />
                </div>

                <!-- Modal for full view -->
                <div
                    class="modal fade"
                    id="imageModal{{ $message->id }}"
                    tabindex="-1"
                    aria-labelledby="imageModalLabel{{ $message->id }}"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <img
                                    src="{{ asset('storage/' . $message->image) }}"
                                    alt="Full Image"
                                    class="img-fluid w-100"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-muted small mt-1 text-end">
                    {{ $message->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <form
        action="{{ route('chat.send', $user->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="input-group mt-2">
            <input
                type="text"
                id="messageInput"
                name="message"
                class="form-control"
                placeholder="Type your message"
            />
            <input
                type="file"
                name="image"
                accept="image/*"
                class="form-control"
                style="max-width: 200px"
            />
            <button
                type="button"
                id="emojiBtn"
                class="btn btn-outline-secondary"
            >
                😊
            </button>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </form>
</div>

@endsection @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const button = document.querySelector("#emojiBtn");
        const input = document.querySelector("#messageInput");

        const picker = new EmojiButton();

        picker.on("emoji", (emoji) => {
            input.value += emoji;
        });

        button.addEventListener("click", () => {
            picker.togglePicker(button);
        });
    });
</script>
@endsection
