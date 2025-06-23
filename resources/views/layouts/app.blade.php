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
                <h5 class="mb-4">PMS</h5>
                <ul class="nav flex-column">
                    @role('admin')
                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white"
                            href="{{ route('admin.dashboard') }}"
                        >
                            <i class="bi bi-speedometer2"></i> Admin Dashboard
                        </a>
                    </li>
                    @endrole
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
                    @isset($project)
                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white {{ request()->routeIs('projects.kanban') ? 'active bg-primary' : '' }}"
                            href="{{ route('projects.kanban', $project->id ?? 1) }}"
                        >
                            🧩 Kanban Board
                        </a>
                    </li>
                    @endisset @php $unreadCount =
                    \App\Models\Message::where('to_user_id', auth()->id())
                    ->whereNull('read_at') ->count(); @endphp
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
                    {{-- ... other nav items ... --}}

                    @role('admin')
                    <li class="nav-item mt-3">
                        <span class="text-white-50">Admin Panel</span>
                    </li>

                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white"
                            href="{{ route('roles.index') }}"
                        >
                            <i class="bi bi-shield-lock"></i> Manage Roles
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a
                            class="nav-link text-white"
                            href="{{ route('users.roles') }}"
                        >
                            <i class="bi bi-people"></i> User Roles
                        </a>
                    </li>
                    @endrole

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
