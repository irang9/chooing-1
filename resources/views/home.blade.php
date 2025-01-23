@extends('layouts.app')

@section('content')
<div class="bd-intro">
    <div class="d-md-flex align-items-center justify-content-start">
        <h1>인트라넷 홈</h1>
        <div class="date ms-3">{{ \Carbon\Carbon::now()->locale('ko')->isoFormat('Y.MM.D(ddd)') }}</div>
    </div>
</div>

<div class="bd-content">
    <div id="calendar"></div>
</div>

<!-- FullCalendar 라이브러리 로드 -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            @if(is_array($vacations) || is_object($vacations))
                @foreach($vacations as $vacation)
                {
                    title: '{{ $vacation->type }} - {{ $vacation->staff ? $vacation->staff->name : 'Unknown' }} ({{ $vacation->duration }})',
                    start: '{{ $vacation->start_date }}',
                    end: '{{ $vacation->end_date }}',
                    url: '{{ route('vacation.show', $vacation->id) }}',
                    color: 'blue'
                },
                @endforeach
            @endif
            @if(is_array($staff) || is_object($staff))
                @foreach($staff as $member)
                {
                    title: '입사일 - {{ $member->name }}',
                    start: '{{ $member->hire_date }}',
                    url: '{{ route('staff.show', $member->id) }}',
                    color: 'green'
                },
                @endforeach
            @endif
        ],
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        locale: 'ko'
    });
    calendar.render();
});
</script>
@endsection
