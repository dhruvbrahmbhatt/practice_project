@extends('layouts.app') @section('title', 'Dashboard') @section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2>Welcome, {{ Auth::user()->name }} 👋</h2>
        <p>You’re successfully logged in to your dashboard.</p>
    </div>

    {{-- Profile Info --}}
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    Your Profile
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p>
                        <strong>Registered on:</strong>
                        {{ Auth::user()->created_at->format('d M, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Cards --}}
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Update Profile</h5>
                    <a
                        href="{{ route('edit') }}"
                        class="btn btn-outline-primary btn-sm"
                        >Edit</a
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <a href="#" class="btn btn-outline-secondary btn-sm"
                        >Change</a
                    >
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Logout</h5>
                    <a
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-danger btn-sm"
                        >Logout</a
                    >

                    <form
                        id="logout-form"
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-none"
                    >
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
