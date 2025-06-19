@extends('layouts.app') @section('title', 'Edit Profile') @section('content')
<div class="container mt-4">
    <h3>Edit Profile</h3>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session("success") }}</div>
    @endif

    {{-- Error Message --}}
    @if($errors->has('update_error'))
    <div class="alert alert-danger">{{ $errors->first('update_error') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name) }}"
                class="form-control"
            />
            @error('name')
            <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                class="form-control"
            />
            @error('email')
            <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
