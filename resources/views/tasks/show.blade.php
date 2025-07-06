@extends('layout')

<style>
    /* CSS Responsif untuk Detail Task */

/* Reset dan full height */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

/* Container wrapper untuk centering - FORCE CENTER! */
.task-detail-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

/* Container utama */
.task-detail-container {
    max-width: 800px;
    width: 100%;
    padding: 30px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: #333;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    position: relative;
    max-height: 90vh;
    overflow-y: auto;
}

/* Heading */
.task-detail-container h1 {
    font-size: 2rem;
    margin-bottom: 1.5rem;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 0.5rem;
    text-align: center;
}

/* Detail items */
.task-detail-item {
    background: #f8f9fa;
    margin-bottom: 1rem;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #3498db;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.task-detail-item strong {
    display: inline-block;
    min-width: 120px;
    color: #2c3e50;
    font-weight: 600;
}

/* Button kembali */
.back-button {
    display: inline-block;
    margin-top: 2rem;
    padding: 12px 24px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.back-button:hover {
    background: #2980b9;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Responsif untuk tablet */
@media (max-width: 768px) {
    .task-detail-wrapper {
        position: fixed;
        padding: 15px;
    }
    
    .task-detail-container {
        padding: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        max-height: 85vh;
    }
    
    .task-detail-container h1 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .task-detail-item {
        padding: 0.8rem;
        margin-bottom: 0.8rem;
    }
    
    .task-detail-item strong {
        min-width: 100px;
    }
}

/* Responsif untuk mobile */
@media (max-width: 480px) {
    .task-detail-wrapper {
        position: fixed;
        padding: 10px;
    }
    
    .task-detail-container {
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        max-height: 80vh;
    }
    
    .task-detail-container h1 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .task-detail-item {
        padding: 12px;
        margin-bottom: 12px;
        border-radius: 6px;
    }
    
    .task-detail-item strong {
        display: block;
        margin-bottom: 4px;
        min-width: auto;
        color: #3498db;
        font-size: 0.9rem;
    }
    
    .task-detail-item p {
        margin: 0;
        padding-left: 0;
    }
    
    .back-button {
        width: 100%;
        text-align: center;
        margin-top: 1.5rem;
        padding: 14px;
        font-size: 1rem;
    }
}

/* Untuk layar sangat kecil */
@media (max-width: 360px) {
    .task-detail-wrapper {
        position: fixed;
        padding: 8px;
    }
    
    .task-detail-container {
        padding: 12px;
        max-height: 75vh;
    }
    
    .task-detail-container h1 {
        font-size: 1.1rem;
    }
    
    .task-detail-item {
        padding: 10px;
        margin-bottom: 10px;
    }
    
    .back-button {
        padding: 12px;
        font-size: 0.9rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .task-detail-wrapper {
        background-color: rgba(0, 0, 0, 0.7);
    }
    
    .task-detail-container {
        color: #e8e8e8;
        background: #2d2d2d;
    }
    
    .task-detail-container h1 {
        color: #ffffff;
        border-bottom-color: #4a90e2;
    }
    
    .task-detail-item {
        background: #3a3a3a;
        border-left-color: #4a90e2;
    }
    
    .task-detail-item strong {
        color: #4a90e2;
    }
    
    .back-button {
        background: #4a90e2;
    }
    
    .back-button:hover {
        background: #357abd;
    }
}
</style>

@section('content')
<div class="task-detail-wrapper">
    <div class="task-detail-container">
        <h1>Detail Task</h1>

        <div class="task-detail-item">
            <p><strong>Title:</strong> {{ $task->title }}</p>
        </div>

        <div class="task-detail-item">
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        </div>

        <div class="task-detail-item">
            <p><strong>Description:</strong> {{ $task->description ?? 'Tidak ada deskripsi' }}</p>
        </div>

        <a href="{{ url()->previous() }}" class="back-button">Kembali</a>
    </div>
</div>
@endsection