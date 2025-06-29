<div class="menu">
    <div class="menu-item {{ request()->routeIs('board') ? 'active' : '' }}">
        <a href="{{ route('board') }}">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBmaWxsPSJjdXJyZW50Q29sb3IiIGQ9Ik0yIDVhMiAyIDAgMCAxIDItMmgxNmEyIDIgMCAwIDEgMiAydjE0YTIgMiAwIDAgMS0yIDJINGEyIDIgMCAwIDEtMi0yem02IDBINHYxNGg0em0yIDB2MTRoNFY1em02IDB2MTRoNFY1eiIvPjwvc3ZnPg==" alt="Board Icon" />
            Board
        </a>
    </div>
    <div class="menu-item {{ request()->routeIs('calendar') ? 'active' : '' }}">
        <!-- <a href="{{ route('board', ['view' => 'calendar']) }}"> -->
        <a href="{{ route('calendar') }}">
            <img src="https://img.icons8.com/ios-filled/50/000000/calendar.png" alt="Calendar Icon" />
            Calendar
        </a>
    </div>
    <div class="menu-item {{ request()->routeIs('list') ? 'active' : '' }}">
        <a href="{{ route('list') }}">
            <img src="https://img.icons8.com/ios-filled/50/000000/list.png" alt="List Icon" />
            List
        </a>
    </div>
    <div class="menu-item {{ request()->routeIs('report') ? 'active' : '' }}">
        <a href="{{ route('report') }}">
            <img src="https://img.icons8.com/?size=100&id=Mc0tQ0XMU2s_&format=png&color=000000/report.png" alt="Report Icon" />
            <span>Report</span>
        </a>
    </div>

    <div class="menu-item user">
        <p>{{Auth::user()->name}}</p>
    </div>
</div>
