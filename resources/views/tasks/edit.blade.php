<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
            padding: 40px;
            min-height: 100vh;
            margin: 0;
        }
        
        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            body {
                padding: 15px 10px;
            }
        }
        
        .card {
            max-width: 500px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
            border: 1px solid rgba(204, 199, 191, 0.2);
            backdrop-filter: blur(10px);
        }
        
        /* Mobile card adjustments */
        @media (max-width: 768px) {
            .card {
                padding: 20px 15px;
                border-radius: 10px;
                max-width: 100%;
                margin: 0;
            }
        }
        
        @media (max-width: 480px) {
            .card {
                padding: 15px 12px;
                border-radius: 8px;
            }
        }
        
        h2 {
            margin-top: 0;
            margin-bottom: 30px;
            text-align: center;
            color: #31393c;
            font-weight: 600;
            font-size: 24px;
            letter-spacing: -0.02em;
        }
        
        @media (max-width: 768px) {
            h2 {
                font-size: 20px;
                margin-bottom: 20px;
            }
        }
        
        @media (max-width: 480px) {
            h2 {
                font-size: 18px;
                margin-bottom: 18px;
            }
        }
        
        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: 500;
            color: #31393c;
            font-size: 12px;
            letter-spacing: 0.01em;
        }
        
        @media (max-width: 768px) {
            label {
                margin-top: 15px;
                margin-bottom: 6px;
                font-size: 11px;
            }
        }
        
        @media (max-width: 480px) {
            label {
                margin-top: 12px;
                margin-bottom: 5px;
                font-size: 10px;
            }
        }
        
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 14px 16px;
            margin-top: 0;
            border: 2px solid #ccc7bf;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #31393c;
            background: #ffffff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        @media (max-width: 768px) {
            input[type="text"],
            input[type="date"],
            select {
                padding: 10px 12px;
                font-size: 13px;
                border-radius: 7px;
                border-width: 1.5px;
            }
        }
        
        @media (max-width: 480px) {
            input[type="text"],
            input[type="date"],
            select {
                padding: 8px 10px;
                font-size: 12px;
                border-radius: 6px;
                border-width: 1px;
            }
        }
        
        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #3e96f4;
            box-shadow: 0 0 0 3px rgba(62, 150, 244, 0.1);
            transform: translateY(-1px);
        }
        
        @media (max-width: 480px) {
            input[type="text"]:focus,
            input[type="date"]:focus,
            select:focus {
                transform: none;
                box-shadow: 0 0 0 2px rgba(62, 150, 244, 0.1);
            }
        }
        
        input[type="text"]:hover,
        input[type="date"]:hover,
        select:hover {
            border-color: #31393c;
        }
        
        /* Disable hover effects on touch devices */
        @media (hover: none) {
            input[type="text"]:hover,
            input[type="date"]:hover,
            select:hover {
                border-color: #ccc7bf;
            }
        }
        
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2331393c' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }
        
        @media (max-width: 768px) {
            select {
                background-size: 14px;
                background-position: right 10px center;
                padding-right: 32px;
            }
        }
        
        @media (max-width: 480px) {
            select {
                background-size: 12px;
                background-position: right 8px center;
                padding-right: 28px;
            }
        }
        
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            gap: 15px;
        }
        
        @media (max-width: 768px) {
            .btn-group {
                margin-top: 25px;
                gap: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .btn-group {
                margin-top: 20px;
                gap: 8px;
            }
        }
        
        button {
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            letter-spacing: 0.01em;
            flex: 1;
            min-height: 48px;
        }
        
        @media (max-width: 768px) {
            button {
                padding: 10px 20px;
                font-size: 13px;
                border-radius: 7px;
                min-height: 40px;
            }
        }
        
        @media (max-width: 480px) {
            button {
                padding: 8px 16px;
                font-size: 12px;
                border-radius: 6px;
                min-height: 36px;
            }
        }
        
        .cancel-btn {
            background: #edeeeb;
            color: #31393c;
            border: 2px solid #ccc7bf;
        }
        
        @media (max-width: 768px) {
            .cancel-btn {
                border-width: 1.5px;
            }
        }
        
        @media (max-width: 480px) {
            .cancel-btn {
                border-width: 1px;
            }
        }
        
        .cancel-btn:hover {
            background: #ccc7bf;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.15);
        }
        
        /* Disable hover effects on touch devices */
        @media (hover: none) {
            .cancel-btn:hover {
                background: #edeeeb;
                transform: none;
                box-shadow: none;
            }
        }
        
        .update-btn {
            background: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
            color: #ffffff;
            border: 2px solid transparent;
        }
        
        @media (max-width: 768px) {
            .update-btn {
                border-width: 1.5px;
            }
        }
        
        @media (max-width: 480px) {
            .update-btn {
                border-width: 1px;
            }
        }
        
        .update-btn:hover {
            background: linear-gradient(135deg, #31393c 0%, #3e96f4 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(62, 150, 244, 0.3);
        }
        
        /* Disable hover effects on touch devices */
        @media (hover: none) {
            .update-btn:hover {
                background: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
                transform: none;
                box-shadow: none;
            }
        }
        
        .update-btn:active,
        .cancel-btn:active {
            transform: translateY(0);
        }
        
        /* Focus states for accessibility */
        button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(62, 150, 244, 0.3);
        }
        
        @media (max-width: 480px) {
            button:focus {
                box-shadow: 0 0 0 2px rgba(62, 150, 244, 0.3);
            }
        }
        
        /* Subtle animation on card load */
        .card {
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
        
        /* Improve link styling in button group */
        .btn-group a {
            flex: 1;
        }
        
        @media (max-width: 480px) {
            .btn-group a {
                width: 100%;
            }
        }
        
        /* Prevent horizontal scroll on very small screens */
        @media (max-width: 320px) {
            .card {
                padding: 12px 8px;
            }
            
            h2 {
                font-size: 16px;
                margin-bottom: 15px;
            }
            
            label {
                font-size: 9px;
                margin-top: 10px;
                margin-bottom: 4px;
            }
            
            input[type="text"],
            input[type="date"],
            select {
                padding: 6px 8px;
                font-size: 11px;
            }
            
            button {
                padding: 6px 12px;
                font-size: 11px;
                min-height: 32px;
            }
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Edit Task</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required>

            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="{{ old('description', $task->description) }}">

            <label for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}">

            <label for="priority_color">Priority Color</label>
            <select name="priority_color" id="priority_color">
                <option value="">None</option>
                <option value="red" {{ $task->priority_color === 'red' ? 'selected' : '' }}>Red</option>
                <option value="yellow" {{ $task->priority_color === 'yellow' ? 'selected' : '' }}>Yellow</option>
                <option value="green" {{ $task->priority_color === 'green' ? 'selected' : '' }}>Green</option>
            </select>

            <div class="btn-group">
                <a href="{{ url('/') }}">
                    <button type="button" class="cancel-btn">Cancel</button>
                </a>
                <button type="submit" class="update-btn">Update Task</button>
            </div>
        </form>
    </div>

</body>
</html>