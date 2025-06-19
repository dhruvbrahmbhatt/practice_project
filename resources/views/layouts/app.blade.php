<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>@yield('title', 'My App')</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
        <script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/emoji-button.min.js"></script>

        <style>
            .nav-link.active {
                background-color: #0d6efd;
                color: #fff !important;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="d-flex">
            {{-- Sidebar --}}
            <div
                class="bg-dark text-white p-3"
                style="width: 220px; min-height: 100vh"
            >
                <h5 class="mb-4">MyApp</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}"
                            href="{{ route('dashboard') }}"
                        >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}"
                            href="{{ route('profile.edit') }}"
                        >
                            Edit Profile
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->is('change-password') ? 'active fw-bold' : '' }}"
                            href="#change-password"
                        >
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->routeIs('projects.*') ? 'active fw-bold' : '' }}"
                            href="{{ route('projects.index') }}"
                        >
                            Projects
                        </a>
                    </li>
                    @php $unreadCount = \App\Models\Message::where('to_user_id',
                    auth()->id()) ->whereNull('read_at') ->count(); @endphp
                    <li class="nav-item mb-2">
                        <a
                            href="{{ route('chat.index') }}"
                            class="nav-link text-white {{ request()->routeIs('chat.index') ? 'active fw-bold' : '' }}"
                        >
                            Chat @if($unreadCount > 0)
                            <span class="badge bg-danger">{{
                                $unreadCount
                            }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->routeIs('group.index') ? 'active fw-bold' : '' }}"
                            href="{{ route('group.index') }}"
                        >
                            <i class="bi bi-people"></i> Group Chat
                        </a>
                    </li>

                    <li class="nav-item mt-4">
                        <a
                            class="nav-link text-white"
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            Logout
                        </a>
                        <form
                            id="logout-form"
                            action="{{ route('logout') }}"
                            method="POST"
                            class="d-none"
                        >
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>

            {{-- Main Content --}}
            <div class="flex-grow-1 p-4">@yield('content')</div>
        </div>
    </body>
</html>

@yield('scripts')
