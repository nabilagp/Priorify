@extends('layout.app')
@section('title', 'Priorify - Board')

@section('content')
    @include('partials.header')
    @include('partials.menu')



    {{-- Tambahkan tabs dan konten list & calendar di sini --}}


    <div id="content-list">
      @include('partials.board-columns') {{-- atau langsung tampilkan list task --}}
    </div>

    <!-- <div id="content-calendar" style="display:none;">
      {{-- Tempat kalender --}}
      <div id="calendar"></div>
    </div> -->

    @include('partials.task-modal')
    @include('partials.delete-modal')
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<style>
  .tabs {
    list-style: none;
    padding: 0;
    margin-bottom: 1rem;
    border-bottom: 1px solid #ccc;
  }
  .tabs li {
    display: inline-block;
    padding: 10px 20px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
  }
  .tabs li.active {
    border-bottom: 3px solid brown;
    font-weight: bold;
  }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<script>
  let calendarInitialized = false;

  function initCalendar() {
    if (calendarInitialized) return;

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      // events: @json($events ?? [])
    });
    calendar.render();

    calendarInitialized = true;
  }

  document.getElementById('tab-list').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('tab-calendar').classList.remove('active');

    document.getElementById('content-list').style.display = 'block';
    document.getElementById('content-calendar').style.display = 'none';
  });

  document.getElementById('tab-calendar').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('tab-list').classList.remove('active');

    document.getElementById('content-calendar').style.display = 'block';
    document.getElementById('content-list').style.display = 'none';

    initCalendar();
  });

  document.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('view') === 'calendar') {
    document.getElementById('tab-calendar').click();
  }
});




</script>
@endpush
