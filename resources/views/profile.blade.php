@extends('layout.app')

@section('title', 'Priorify - Profile')

@section('content')

{{-- PENTING: JIKA HEADER GLOBAL SUDAH DI 'layout.app', HAPUS BARIS DI BAWAH INI.
   Jika Anda membiarkan ini, akan ada DUA header di halaman profil.
   Sangat disarankan header hanya di-include sekali di layout.app. --}}
{{-- @include('partials.header') --}}


<style>
    /* Reset margin dan padding pada body/html */
    body, html {
        margin: 0;
        padding: 0; 
        box-sizing: border-box;
        overflow-x: hidden; 
    }

    /* PENTING: CSS untuk menyembunyikan lingkaran akun dan dropdown-nya
       HANYA DI HALAMAN INI (profile.blade.php).
       Ini menargetkan `.profile-container` yang berada di dalam `.header`.
    */
    .header .profile-container {
        display: none !important; 
    }

    /* Sesuaikan margin-top ini. Ini harus sama dengan tinggi total header Anda
       setelah elemen `.profile-container` dihapus/disembunyikan.
       Ukur tinggi *aktual* dari header "Priorify" Anda (logo + Priorify + padding atas/bawah).
       Mungkin sekitar 60px-70px tergantung paddingnya. Mulai dengan 60px dan sesuaikan.
    */
    .profile-container {
        /* Default margin-top untuk desktop dan mobile */
        margin-top: 60px; /* <--- SESUAIKAN NILAI INI DENGAN TINGGI HEADER ANDA! */
        padding: 0 20px 20px 20px; /* Hapus padding atas jika sudah diatur oleh margin-top */
        font-family: 'Inter', sans-serif;
        width: 100%;
        min-height: calc(100vh - 60px); /* Sesuaikan min-height agar tidak terlalu pendek */
    }

    /* ... CSS lainnya untuk .profile-card, .profile-header, dll. tetap sama ... */
    .profile-card {
        max-width: 800px;
        margin: 0 auto; /* Ini akan ditimpa oleh margin di media query */
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(49, 57, 60, 0.08);
        overflow: hidden;
        position: relative;
    }

    .profile-header {
        background: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
        padding: 40px 30px;
        color: #ffffff;
        text-align: center;
        position: relative;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.05"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
        opacity: 0.3;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: #ccc7bf;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        color: #31393c;
        position: relative;
        z-index: 1;
    }

    .profile-name {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
        position: relative;
        z-index: 1;
    }

    .profile-email {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .back-button {
        position: absolute;
        top: 30px;
        right: 30px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #ffffff;
        padding: 8px 16px;
        border-radius: 25px;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        z-index: 2;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }

    .profile-content {
        padding: 40px 30px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .info-section {
        background: #edeeeb;
        padding: 25px;
        border-radius: 15px;
        border-left: 4px solid #3e96f4;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #31393c;
        margin: 0 0 20px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 8px;
        height: 8px;
        background: #3e96f4;
        border-radius: 50%;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #ccc7bf;
        font-size: 15px;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-weight: 500;
        color: #31393c;
        flex: 1;
    }

    .info-value {
        color: #31393c;
        font-weight: 400;
        text-align: right;
        flex: 1.5;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .stat-card {
        background: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        transform: rotate(45deg);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
        position: relative;
        z-index: 1;
    }

    .stat-label {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .motivational-quote {
        background: linear-gradient(135deg, #ccc7bf 0%, #edeeeb 100%);
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        margin-top: 30px;
        position: relative;
    }

    .quote-text {
        font-size: 16px;
        font-style: italic;
        color: #31393c;
        margin: 0;
        line-height: 1.6;
    }

    .quote-icon {
        position: absolute;
        top: 10px;
        left: 20px;
        font-size: 24px;
        color: #3e96f4;
        opacity: 0.3;
    }

    /* --- Media Queries for Responsiveness --- */
    @media screen and (max-width: 768px) {
        .profile-container {
            margin-top: 60px; /* Sesuaikan ini sesuai tinggi header mobile Anda */
            padding: 0 15px 15px 15px;
            min-height: calc(100vh - 60px);
        }
        
        .profile-card {
            margin: 0;
            border-radius: 15px;
            overflow: hidden; 
            position: relative;
            box-shadow: 0 10px 30px rgba(49, 57, 60, 0.1);
        }

        .profile-header {
            padding: 20px 20px;
        }

        .back-button {
            top: 15px;
            right: 15px;
            padding: 8px 14px;
            font-size: 13px;
            border-radius: 20px;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            font-size: 28px;
            margin: 0 auto 10px;
        }

        .profile-name {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .profile-email {
            font-size: 14px;
        }

        .profile-content {
            padding: 20px 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin: 15px 0;
        }

        .stat-card {
            padding: 15px 12px;
        }

        .stat-number {
            font-size: 26px;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-section {
            padding: 18px;
            border-radius: 12px;
        }

        .section-title {
            font-size: 16px;
            margin-bottom: 12px;
        }

        .info-item {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            gap: 10px;
        }

        .info-label {
            font-size: 14px;
            flex: 1.2;
            font-weight: 500;
            line-height: 1.3;
        }

        .info-value {
            font-size: 14px;
            flex: 1;
            text-align: right;
            line-height: 1.3;
            word-break: break-word;
        }

        .motivational-quote {
            padding: 15px;
            margin-top: 15px;
        }

        .quote-text {
            font-size: 14px;
            line-height: 1.4;
        }

        .quote-icon {
            font-size: 18px;
            top: 6px;
            left: 12px;
        }
    }

    @media screen and (max-width: 480px) {
        .profile-container {
            margin-top: 55px; /* Sesuaikan ini sesuai tinggi header mobile kecil Anda */
            padding: 0 10px 10px 10px;
            min-height: calc(100vh - 55px);
        }

        .profile-card {
            border-radius: 12px;
        }

        .profile-header {
            padding: 15px 15px;
        }

        .back-button {
            top: 10px;
            right: 10px;
            padding: 6px 12px;
            font-size: 12px;
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .profile-name {
            font-size: 20px;
            margin-bottom: 3px;
        }

        .profile-email {
            font-size: 13px;
        }

        .profile-content {
            padding: 15px 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 8px;
            margin: 10px 0;
        }

        .stat-card {
            padding: 12px;
            border-radius: 10px;
        }

        .stat-number {
            font-size: 24px;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 11px;
        }

        .info-section {
            padding: 15px;
            border-radius: 10px;
        }

        .section-title {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .section-title::before {
            width: 5px;
            height: 5px;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
            padding: 6px 0;
        }

        .info-label {
            font-size: 12px;
            width: 100%;
            text-align: left;
            margin-bottom: 1px;
            font-weight: 600;
            color: #31393c;
        }

        .info-value {
            font-size: 12px;
            width: 100%;
            text-align: left;
            font-weight: 400;
            color: #555;
        }

        .motivational-quote {
            padding: 12px;
            margin-top: 10px;
            border-radius: 10px;
        }

        .quote-text {
            font-size: 12px;
            line-height: 1.3;
        }

        .quote-icon {
            font-size: 16px;
            top: 4px;
            left: 8px;
        }
    }

    /* Extra small devices (320px and down) */
    @media screen and (max-width: 320px) {
        .profile-container {
            margin-top: 50px; /* Sesuaikan ini sesuai tinggi header sangat kecil Anda */
            padding: 0 8px 8px 8px;
            min-height: calc(100vh - 50px);
        }

        .profile-card {
            border-radius: 8px;
        }

        .profile-header {
            padding: 12px 10px;
        }

        .profile-content {
            padding: 12px 10px;
        }

        .back-button {
            top: 8px;
            right: 8px;
            padding: 4px 8px;
            font-size: 11px;
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            font-size: 20px;
            margin-bottom: 6px;
        }

        .profile-name {
            font-size: 18px;
            margin-bottom: 2px;
        }

        .profile-email {
            font-size: 11px;
        }

        .stats-grid {
            gap: 6px;
            margin: 8px 0;
        }

        .stat-card {
            padding: 10px;
        }

        .stat-number {
            font-size: 20px;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 10px;
        }

        .info-section {
            padding: 12px;
        }

        .section-title {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-item {
            padding: 4px 0;
        }

        .info-label {
            font-size: 11px;
        }

        .info-value {
            font-size: 11px;
        }

        .motivational-quote {
            padding: 10px;
            margin-top: 8px;
        }

        .quote-text {
            font-size: 11px;
            line-height: 1.2;
        }

        .quote-icon {
            font-size: 14px;
            top: 3px;
            left: 6px;
        }
    }
</style>

@php
    use Carbon\Carbon;
    use App\Models\Column;

    $user = Auth::user();

    // Ambil semua task user
    $tasks = $user->tasks;

    // Ambil semua column (To Do, In Progress, Completed, dsb)
    $columns = Column::pluck('name', 'id'); // [id => name]

    // Cari ID kolom "Completed"
    $completedColumnId = $columns->search('Completed');

    // Hitung total task, completed, dan pending
    $taskCount = $tasks->count();
    $completedTasks = $completedColumnId ? $tasks->where('column_id', $completedColumnId)->count() : 0;
    $pendingTasks = $taskCount - $completedTasks;

    // Ambil task terakhir
    $lastTask = $tasks->sortByDesc('created_at')->first();
@endphp

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <a href="{{ url()->previous() }}" class="back-button">← Back</a>
            
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            
            <h1 class="profile-name">{{ $user->name }}</h1>
            <p class="profile-email">{{ $user->email }}</p>
        </div>

        <div class="profile-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $taskCount }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $completedTasks }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $pendingTasks }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $user->created_at->diffInDays(now()) }}</div>
                    <div class="stat-label">Days Active</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-section">
                    <h3 class="section-title">Account Information</h3>
                    <div class="info-item">
                        <span class="info-label">User ID</span>
                        <span class="info-value">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Type</span>
                        <span class="info-value">{{ $user->gauth_type ?? 'Email/Password' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member Since</span>
                        <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">Activity Summary</h3>
                    <div class="info-item">
                        <span class="info-label">Last Task Created</span>
                        <span class="info-value" id="latest-task-date">
                            {{ $lastTask ? $lastTask->created_at->format('d M Y') : 'No tasks yet' }}
                        </span>
                    </div>
                    @if($lastTask)
                    <div class="info-item">
                        <span class="info-label">Latest Task</span>
                        <span class="info-value" id="latest-task-title">
                            {{ $lastTask ? Str::limit($lastTask->title, 30) : 'No tasks yet' }}
                        </span>
                    </div>
                    @endif
                    <div class="info-item">
                        <span class="info-label">Completion Rate</span>
                        <span class="info-value">
                            {{ $taskCount > 0 ? round(($completedTasks / $taskCount) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>

            <div class="motivational-quote">
                <div class="quote-icon">"</div>
                <p class="quote-text">
                    Keep managing your priorities wisely. Priorify helps you stay organized and on track to achieve your goals.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function fetchLatestTask() {
        fetch('{{ route('latest-task') }}')
            .then(res => res.json())
            .then(data => {
                document.getElementById('latest-task-title').textContent = data.title;
                document.getElementById('latest-task-date').textContent = data.created_at;
            })
            .catch(error => console.error('Failed to fetch latest task:', error));
    }

    // Ambil data saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', () => {
        fetchLatestTask();

        // Atau refresh setiap 60 detik (opsional)
        setInterval(fetchLatestTask, 60000);
    });
</script>