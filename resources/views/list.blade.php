@extends('layout.app')
@section('title', 'Priorify - List')

@section('content')
@include('partials.header')
@include('partials.menu')

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(49, 57, 60, 0.08);
    }

    th, td {
        padding: 16px 14px;
        border: none;
        text-align: left;
        font-size: 12px;
        border-bottom: 1px solid rgba(204, 199, 191, 0.3);
        color: #31393c;
    }

    thead th {
        background: linear-gradient(135deg, #edeeeb 0%,rgb(192, 191, 204) 100%);
        font-weight: 600;
        color: #31393c;
        letter-spacing: 0.02em;
        font-size: 12px;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    tbody tr:nth-child(even) {
        background-color: rgba(237, 238, 235, 0.3);
    }

    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .scroll-area {
        padding: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
        min-height: calc(100vh - 150px);
    }

    /* --- START: DESKTOP STYLES (DEFAULT) --- */
    .section-header {
        display: flex;
        justify-content: space-between; /* Untuk menempatkan List View di kiri dan search bar di kanan */
        align-items: center; /* Sejajarkan secara vertikal */
        margin-bottom: 20px;
        padding: 0 4px;
    }

    h2.section-title {
        color: #31393c;
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .search-bar form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .search-bar input[type="text"] {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #ccc7bf;
        font-size: 12px;
        background: #ffffff;
        color: #31393c;
        transition: all 0.3s ease;
        min-width: 240px; /* Lebar minimum untuk desktop */
        font-family: 'Inter', sans-serif;
    }

    .search-bar input[type="text"]:focus {
        outline: none;
        border-color: #3e96f4;
        box-shadow: 0 0 0 3px rgba(62, 150, 244, 0.1);
        transform: translateY(-1px);
    }

    .search-bar input[type="text"]:hover {
        border-color: #31393c;
    }

    .search-bar button {
        padding: 12px 20px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
        color: #ffffff;
        border: none;
        cursor: pointer;
        font-weight: 500;
        font-size: 12px;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .search-bar button:hover {
        background: linear-gradient(135deg, #31393c 0%, #3e96f4 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(62, 150, 244, 0.3);
    }
    /* --- END: DESKTOP STYLES (DEFAULT) --- */

    .scrollable-table {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 12px;
        border: 1px solid rgba(204, 199, 191, 0.4);
        background: #ffffff;
        box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
    }

    .scrollable-table::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-table::-webkit-scrollbar-track {
        background: #edeeeb;
        border-radius: 4px;
    }

    .scrollable-table::-webkit-scrollbar-thumb {
        background: #ccc7bf;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .scrollable-table::-webkit-scrollbar-thumb:hover {
        background: #31393c;
    }

    .priority-header, .deadline-header, .status-header {
        position: relative;
        padding-right: 32px;
    }

    .icon-button {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: bold;
        cursor: pointer;
        opacity: 0;
        transition: all 0.3s ease;
        pointer-events: none;
        user-select: none;
        color: #3e96f4;
        font-size: 16px;
    }

    .priority-header:hover .icon-button,
    .deadline-header:hover .icon-button,
    .status-header:hover .icon-button {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(-50%) scale(1.1);
    }

    .dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: #ffffff;
        border: 1px solid rgba(204, 199, 191, 0.4);
        border-radius: 8px;
        z-index: 20;
        display: none;
        min-width: 160px;
        box-shadow: 0 8px 32px rgba(49, 57, 60, 0.15);
        backdrop-filter: blur(10px);
        overflow: hidden;
        margin-top: 4px;
    }

    .dropdown button {
        width: 100%;
        text-align: left;
        padding: 12px 16px;
        border: none;
        background: #ffffff;
        cursor: pointer;
        color: #31393c;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .dropdown button:hover {
        background: linear-gradient(135deg, #3e96f4 0%, rgba(62, 150, 244, 0.1) 100%);
        color: #3e96f4;
        transform: translateX(4px);
    }

    .completed-row {
        color: #ccc7bf;
        opacity: 0.7;
        background-color: rgba(237, 238, 235, 0.5) !important;
        font-style: italic;
    }

    .completed-row td {
        text-decoration: line-through;
    }

    tbody tr {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    tbody tr:hover {
        background: linear-gradient(135deg, rgba(62, 150, 244, 0.05) 0%, rgba(237, 238, 235, 0.8) 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(49, 57, 60, 0.1);
    }

    tbody tr:hover td {
        color: #31393c;
    }

    /* Priority indicator styles */
    tbody td span[style*="border-radius:50%"] {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        border: 2px solid #ffffff;
        transition: transform 0.2s ease;
    }

    tbody tr:hover td span[style*="border-radius:50%"] {
        transform: scale(1.1);
    }

    /* Improved no data state */
    .text-center {
        color: #ccc7bf;
        font-style: italic;
        padding: 40px 20px !important;
        font-size: 16px;
    }

    /* Animation for table load */
    .scrollable-table {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* --- START: MOBILE RESPONSIVE ENHANCEMENTS (max-width: 768px) --- */
    @media (max-width: 768px) {
        .section-header {
            flex-direction: column; /* Stack title and search bar vertically */
            gap: 16px;
            align-items: stretch; /* Make them take full width */
            margin-bottom: 25px; /* More space below header */
            padding: 0 20px; /* PENTING: Tambahkan padding horizontal agar tidak keluar garis */
            box-sizing: border-box; /* Pastikan padding dihitung dalam lebar */
        }
        
        .search-bar {
            width: 100%; /* Ensure search bar takes full width of its parent */
            box-sizing: border-box; /* Pastikan padding dihitung dalam lebar */
        }

        /* Search Bar Form: Input dan Button Sejajar Rapi */
        .search-bar form {
            display: flex; /* Gunakan flexbox untuk mensejajarkan input dan button */
            flex-direction: row; /* Atur secara horizontal */
            gap: 10px; /* Jarak antara input dan button */
            width: 100%; /* Pastikan form mengambil lebar penuh */
            align-items: center; /* Sejajarkan secara vertikal di tengah */
            box-sizing: border-box; /* Penting agar tidak keluar garis */
        }

        .search-bar input[type="text"] {
            flex-grow: 1; /* Input mengambil sisa ruang yang tersedia */
            min-width: 0; /* Penting: Izinkan input menyusut jika perlu */
            width: auto; /* Dikelola oleh flex-grow */
            box-sizing: border-box; /* Pastikan padding & border masuk perhitungan lebar */
            font-size: 12px; /* Ukuran font untuk mobile */
            padding: 10px 14px; /* Padding untuk input */
        }

        .search-bar button {
            flex-shrink: 0; /* Tombol tidak menyusut */
            width: auto; /* Lebar tombol sesuai kontennya (teks "Search") */
            padding: 10px 18px; /* Padding untuk tombol */
            font-size: 12px; /* Ukuran font untuk tombol */
            box-sizing: border-box; /* Pastikan padding & border masuk perhitungan lebar */
        }
    }
    /* --- END: MOBILE RESPONSIVE ENHANCEMENTS --- */
</style>

<div class="scroll-area">

    <!-- Judul dan Search Bar Sejajar -->
    <div class="section-header">
        <h2 class="section-title">List View</h2>
        <div class="search-bar">
            <form method="GET" action="{{ route('list') }}">
                <input type="text" name="search" placeholder="Search task..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="scrollable-table">
        <table class="table table-bordered table-striped mb-0" id="taskTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Task Title</th>
                    <th class="status-header">
                        Status
                        <span class="icon-button">•••</span>
                        <div class="dropdown" id="statusDropdown">
                            <button onclick="sortByStatus('To Do')">To Do</button>
                            <button onclick="sortByStatus('In Progress')">In Progress</button>
                            <button onclick="sortByStatus('Completed')">Completed</button>
                            <button onclick="resetSort()">Default</button>
                        </div>
                    </th>
                    <th class="priority-header">
                        Priority
                        <span class="icon-button">•••</span>
                        <div class="dropdown" id="priorityDropdown">
                            <button onclick="sortByPriority('High')">High</button>
                            <button onclick="sortByPriority('Medium')">Medium</button>
                            <button onclick="sortByPriority('Low')">Low</button>
                            <button onclick="resetSort()">Default</button>
                        </div>
                    </th>
                    <th class="deadline-header">
                        Deadline
                        <span class="icon-button">•••</span>
                        <div class="dropdown" id="deadlineDropdown">
                            <button onclick="sortDeadlineAsc()">▲ Closest</button>
                            <button onclick="sortDeadlineDesc()">▼ Furthest</button>
                            <button onclick="resetSort()">⟳ Default</button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="taskTableBody">
                @php
                    $priorityMap = [
                        'red' => ['label' => 'High', 'color' => '#ff9999', 'order' => 3],
                        'yellow' => ['label' => 'Medium', 'color' => '#ffffcc', 'order' => 2],
                        'green' => ['label' => 'Low', 'color' => '#b3ffb3', 'order' => 1],
                        'blue' => ['label' => 'Info', 'color' => '#add8e6', 'order' => 0],
                        'purple' => ['label' => 'Other', 'color' => '#e0bbff', 'order' => 0],
                    ];

                    $filteredTasks = $tasks;

                    if (request()->has('search')) {
                        $keyword = strtolower(request('search'));
                        $filteredTasks = $tasks->filter(function ($task) use ($keyword) {
                            return str_contains(strtolower($task->title), $keyword);
                        });
                    }

                    $sortedTasks = $filteredTasks->sortByDesc('created_at')->values();
                @endphp

                @forelse($sortedTasks as $index => $task)
                    @php
                        $priority = $priorityMap[$task->priority_color] ?? ['label' => 'Unknown', 'color' => '#cccccc', 'order' => 0];
                        $status = $task->column->name ?? '-';
                        $isCompleted = $status === 'Completed';
                    @endphp
                    <tr 
                        class="{{ $isCompleted ? 'completed-row' : '' }}"
                        data-priority-label="{{ $priority['label'] }}"
                        data-priority-order="{{ $priority['order'] }}"
                        data-status="{{ $status }}"
                        data-original-index="{{ $index }}"
                        data-deadline="{{ \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') }}"
                    >
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $status }}</td>
                        <td>
                            <span style="display:inline-block;width:16px;height:16px;border-radius:50%;background-color:{{ $priority['color'] }};margin-right:5px;"></span>
                            {{ $priority['label'] }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada tugas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function sortByPriority(label) {
        const tbody = document.getElementById('taskTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr[data-priority-label]'));
        rows.sort((a, b) => {
            const aMatch = a.dataset.priorityLabel === label ? 1 : 0;
            const bMatch = b.dataset.priorityLabel === label ? 1 : 0;
            return bMatch - aMatch;
        });
        rows.forEach(row => tbody.appendChild(row));
    }

    function sortByStatus(status) {
        const tbody = document.getElementById('taskTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr[data-status]'));
        rows.sort((a, b) => {
            const aMatch = a.dataset.status === status ? 1 : 0;
            const bMatch = b.dataset.status === status ? 1 : 0;
            return bMatch - aMatch;
        });
        rows.forEach(row => tbody.appendChild(row));
    }

    function sortDeadlineAsc() {
        const tbody = document.getElementById('taskTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr[data-deadline]'));
        rows.sort((a, b) => new Date(a.dataset.deadline) - new Date(b.dataset.deadline));
        rows.forEach(row => tbody.appendChild(row));
    }

    function sortDeadlineDesc() {
        const tbody = document.getElementById('taskTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr[data-deadline]'));
        rows.sort((a, b) => new Date(b.dataset.deadline) - new Date(a.dataset.deadline));
        rows.forEach(row => tbody.appendChild(row));
    }

    function resetSort() {
        const tbody = document.getElementById('taskTableBody');
        const rows = Array.from(tbody.querySelectorAll('tr[data-original-index]'));
        rows.sort((a, b) => parseInt(a.dataset.originalIndex) - parseInt(b.dataset.originalIndex));
        rows.forEach(row => tbody.appendChild(row));
    }

    function setupHoverDropdown(headerClass, dropdownId) {
        const header = document.querySelector(headerClass);
        const dropdown = document.getElementById(dropdownId);

        if (header && dropdown) {
            let timeout;
            
            header.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                dropdown.style.display = 'block';
            });

            header.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => {
                    dropdown.style.display = 'none';
                }, 200);
            });

            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(timeout);
                dropdown.style.display = 'block';
            });

            dropdown.addEventListener('mouseleave', () => {
                dropdown.style.display = 'none';
            });
        }
    }

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        setupHoverDropdown('.priority-header', 'priorityDropdown');
        setupHoverDropdown('.deadline-header', 'deadlineDropdown');
        setupHoverDropdown('.status-header', 'statusDropdown');
    });
</script>
@endsection