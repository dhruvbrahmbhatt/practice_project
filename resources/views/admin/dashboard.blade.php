@extends('layouts.app') @section('content')
<div class="container">
    <h3>Admin Dashboard – User Task Overview</h3>

    @foreach($users as $user)
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            {{ $user->name }} ({{ $user->email }})
            <span
                class="badge bg-info"
                >{{ $user->getRoleNames()->join(', ') }}</span
            >
        </div>
        <div class="card-body">
            <p><strong>Performance:</strong> {{ $user->performance }}%</p>

            @if($user->tasks->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name ?? 'N/A' }}</td>
                        <td>{{ $task->status->name ?? 'N/A' }}</td>
                        <td>{{ $task->due_date ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-muted">No tasks assigned.</p>
            @endif
        </div>
    </div>

    @endforeach
    <div class="card mb-4">
        <div class="card-header">Employee Time Logged</div>
        <div class="card-body">
            <canvas id="employeeTimeChart" height="120"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('dailyHoursChart')?.getContext('2d');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels), // e.g., ['20 Jun', '21 Jun', ...]
                datasets: [{
                    label: 'Total Hours Logged',
                    data: @json($data),   // e.g., [4, 8, 2, 6]
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours Logged'
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
