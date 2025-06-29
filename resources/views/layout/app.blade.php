<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Priorify')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    
    {{-- Tambahkan ini --}}
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">


    @include('partials.style')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
</head>
<body>
    <div class="app-container">
        @yield('content')
    </div>
    @include('partials.script')
</body>
</html>
