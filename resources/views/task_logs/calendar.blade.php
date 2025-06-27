@extends('layouts.app') @section('title', 'Task Calendar') @section('content')
<div class="container mt-4">
    <h3 class="mb-4">My Logged Tasks Calendar</h3>
    <div id="calendar"></div>
</div>

<!-- FullCalendar CDN -->
<link
    href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css"
    rel="stylesheet"
/>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            events: @json($calendarTasks ?? []),
            eventClick: function(info) {
                const date = info.event.startStr;
                window.location.href = `/tasks/date/${date}`;
            }
        });
        calendar.render();
    });
</script>
@endsection
