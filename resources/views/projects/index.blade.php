@extends('layouts.app') @section('title', 'Projects') @section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Projects</h4>
    <a href="{{ route('projects.create') }}" class="btn btn-primary"
        >+ New Project</a
    >
</div>

@if(session('success'))
<div class="alert alert-success">{{ session("success") }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Created At</th>
            <th width="150">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $project)
        <tr>
            <td>{{ $project->name }}</td>
            <td>
                <span
                    class="badge bg-{{ $project->status->color ?? 'secondary' }}"
                    >{{ $project->status->name ?? 'N/A' }}</span
                >
            </td>
            <td>{{ $project->created_at->format('d M Y') }}</td>
            <td>
                <a
                    href="{{ route('projects.edit', $project) }}"
                    class="btn btn-sm btn-warning"
                    >Edit</a
                >
            </td>
            <td>
                <a
                    href="{{ route('invoice.download', $project->id) }}"
                    class="btn btn-primary"
                    >Generate Invoice</a
                >
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No projects found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
