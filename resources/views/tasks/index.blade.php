<h5>Tasks</h5>
<ul>
    @foreach($project->tasks as $task)
    <li>
        {{ $task->title }} -
        <small>{{ $task->status->name ?? 'No Status' }}</small>
    </li>
    @endforeach
</ul>
