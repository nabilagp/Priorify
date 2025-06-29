<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priorify Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg,rgb(0, 0, 100) 0%,rgb(176, 185, 210) 25%,rgb(139, 144, 162) 50%,rgb(48, 48, 85) 75%,rgb(32, 36, 57) 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            color: #31393c;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-dot {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
            animation: floatUpDown 8s ease-in-out infinite;
        }

        .floating-dot:nth-child(1) {
            width: 8px;
            height: 8px;
            background: #3e96f4;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-dot:nth-child(2) {
            width: 6px;
            height: 6px;
            background: #ccc7bf;
            top: 60%;
            left: 85%;
            animation-delay: -2s;
        }

        .floating-dot:nth-child(3) {
            width: 10px;
            height: 10px;
            background: #edeeeb;
            top: 80%;
            left: 15%;
            animation-delay: -4s;
        }

        .floating-dot:nth-child(4) {
            width: 7px;
            height: 7px;
            background: #31393c;
            top: 30%;
            left: 70%;
            animation-delay: -1s;
            opacity: 0.3;
        }

        .floating-dot:nth-child(5) {
            width: 5px;
            height: 5px;
            background: #3e96f4;
            top: 50%;
            left: 5%;
            animation-delay: -3s;
        }

        .floating-dot:nth-child(6) {
            width: 9px;
            height: 9px;
            background: #ccc7bf;
            top: 15%;
            left: 90%;
            animation-delay: -5s;
        }

        @keyframes floatUpDown {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-30px) rotate(180deg);
                opacity: 0.3;
            }
        }

        /* Subtle geometric shapes */
        .geo-shape {
            position: absolute;
            border: 1px solid;
            opacity: 0.15;
            animation: rotate 20s linear infinite;
        }

        .geo-shape.triangle {
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 25px solid #3e96f4;
            top: 25%;
            right: 20%;
            animation-delay: -5s;
        }

        .geo-shape.square {
            width: 20px;
            height: 20px;
            background: transparent;
            border: 1px solid #ccc7bf;
            top: 70%;
            right: 10%;
            animation-delay: -10s;
        }

        .geo-shape.circle {
            width: 18px;
            height: 18px;
            border: 1px solid #edeeeb;
            border-radius: 50%;
            top: 40%;
            left: 8%;
            animation-delay: -15s;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            border-bottom: 1px solid rgba(237, 238, 235, 0.5);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #31393c;
            font-weight: 600;
            font-size: 18px;
        }

        .logo i {
            background: #3e96f4;
            color: white;
            padding: 6px;
            border-radius: 6px;
            font-size: 14px;
        }

        .nav-menu {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .nav-menu a {
            color: #31393c;
            text-decoration: none;
            font-weight: 400;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #3e96f4;
        }

        .contact-btn {
            background: #3e96f4;
            padding: 8px 16px;
            border-radius: 6px;
            color: white !important;
            transition: all 0.3s ease;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .contact-btn:hover {
            background: #2c7bd4;
            transform: translateY(-1px);
            color: white !important;
        }

        .contact-btn i {
            font-size: 14px;
        }

        /* Mobile contact button */
        .mobile-contact-btn {
            display: none;
        }

        /* Main container */
        .container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            padding: 80px 40px 40px;
            gap: 60px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        /* Left section */
        .left-section {
            flex: 1;
            max-width: 500px;
        }

        .headline {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            color: #31393c;
        }

        .headline span {
            color: #3e96f4;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #ccc7bf;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* Minimal illustration */
        .illustration {
            position: relative;
            width: 300px;
            height: 200px;
            margin: 30px 0;
        }

        .task-card {
            position: absolute;
            background: white;
            border: 1px solid #edeeeb;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(49, 57, 60, 0.08);
            animation: float 6s ease-in-out infinite;
        }

        .task-card.card1 {
            width: 120px;
            top: 20px;
            left: 20px;
            background: #3e96f4;
            color: white;
        }

        .task-card.card2 {
            width: 100px;
            top: 80px;
            right: 40px;
            animation-delay: -2s;
        }

        .task-card.card3 {
            width: 110px;
            bottom: 30px;
            left: 60px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .task-text {
            font-size: 11px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .task-progress {
            width: 100%;
            height: 3px;
            background: rgba(237, 238, 235, 0.5);
            border-radius: 2px;
            overflow: hidden;
        }

        .task-progress-fill {
            height: 100%;
            background: #edeeeb;
            border-radius: 2px;
        }

        .card1 .task-progress {
            background: rgba(255, 255, 255, 0.3);
        }

        .card1 .task-progress-fill {
            background: white;
            width: 80%;
        }

        .card2 .task-progress-fill {
            background: #3e96f4;
            width: 60%;
        }

        .card3 .task-progress-fill {
            background: #ccc7bf;
            width: 40%;
        }

        /* Right section - Login Form */
        .right-section {
            flex: 0 0 380px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(237, 238, 235, 0.8);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
        }

        .login-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #31393c;
            margin-bottom: 6px;
            text-align: center;
        }

        .login-subtitle {
            color: #ccc7bf;
            margin-bottom: 32px;
            font-size: 14px;
            text-align: center;
        }

        .google-btn {
            width: 100%;
            background: white;
            border: 1px solid #edeeeb;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #31393c;
        }

        .google-btn:hover {
            border-color: #ccc7bf;
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.12);
            transform: translateY(-2px);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="%234285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="%2334A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="%23FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="%23EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>') no-repeat center;
            background-size: contain;
        }

        .error-message {
            background: #fee;
            color: #c53030;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
            font-size: 14px;
            text-align: center;
        }

        .success-message {
            background: #f0f9ff;
            color: #0369a1;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
            font-size: 14px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                gap: 50px;
                padding: 100px 30px 30px;
                text-align: center;
            }
            
            .headline {
                font-size: 2.8rem;
                margin-bottom: 18px;
            }
            
            .subtitle {
                font-size: 1.2rem;
                margin-bottom: 35px;
            }
            
            .illustration {
                width: 350px;
                height: 240px;
                margin: 30px auto;
            }
            
            .task-card.card1 {
                width: 140px;
                top: 25px;
                left: 25px;
            }
            
            .task-card.card2 {
                width: 120px;
                top: 100px;
                right: 40px;
            }
            
            .task-card.card3 {
                width: 130px;
                bottom: 35px;
                left: 70px;
            }
            
            .right-section {
                flex: none;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 12px 20px;
            }
            
            .logo {
                font-size: 16px;
            }
            
            .nav-menu {
                display: none;
            }

            .mobile-contact-btn {
                display: flex;
                align-items: center;
                background: #3e96f4;
                padding: 8px 12px;
                border-radius: 6px;
                color: white;
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
                gap: 6px;
                transition: all 0.3s ease;
            }

            .mobile-contact-btn:hover {
                background: #2c7bd4;
                transform: translateY(-1px);
            }

            .mobile-contact-btn i {
                font-size: 14px;
            }
            
            .container {
                padding: 80px 20px 20px;
                gap: 25px; /* Reduced from 40px */
            }
            
            .headline {
                font-size: 2.5rem;
                margin-bottom: 16px;
            }
            
            .subtitle {
                font-size: 1.15rem;
                margin-bottom: 25px; /* Reduced from 30px */
            }
            
            .illustration {
                width: 320px;
                height: 220px;
                margin: 20px auto; /* Reduced from 25px auto */
            }
            
            .task-card {
                padding: 16px;
                border-radius: 10px;
            }
            
            .task-card.card1 {
                width: 130px;
                top: 20px;
                left: 20px;
            }
            
            .task-card.card2 {
                width: 115px;
                top: 90px;
                right: 35px;
            }
            
            .task-card.card3 {
                width: 120px;
                bottom: 30px;
                left: 60px;
            }
            
            .task-text {
                font-size: 13px;
                margin-bottom: 8px;
            }
            
            .login-container {
                padding: 28px 24px;
                margin: 0 10px;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .login-subtitle {
                margin-bottom: 28px;
            }
            
            .google-btn {
                padding: 13px 16px;
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 10px 15px;
            }

            .mobile-contact-btn {
                padding: 6px 10px;
                font-size: 13px;
                gap: 5px;
            }

            .mobile-contact-btn i {
                font-size: 13px;
            }

            .container {
                padding: 70px 15px 15px;
                gap: 20px; /* Reduced from 30px */
            }
            
            .headline {
                font-size: 2.2rem;
                margin-bottom: 14px;
            }
            
            .subtitle {
                font-size: 1.1rem;
                margin-bottom: 20px; /* Reduced from 25px */
            }
            
            .illustration {
                width: 280px;
                height: 200px;
                margin: 15px auto; /* Reduced from 20px auto */
            }
            
            .task-card {
                padding: 14px;
                border-radius: 8px;
            }
            
            .task-card.card1 {
                width: 115px;
                top: 15px;
                left: 15px;
            }
            
            .task-card.card2 {
                width: 100px;
                top: 80px;
                right: 30px;
            }
            
            .task-card.card3 {
                width: 105px;
                bottom: 25px;
                left: 50px;
            }
            
            .task-text {
                font-size: 12px;
                margin-bottom: 7px;
            }
            
            .login-container {
                padding: 24px 20px;
                margin: 0 5px;
            }
            
            .login-title {
                font-size: 1.4rem;
            }
            
            .login-subtitle {
                margin-bottom: 24px;
            }
            
            .google-btn {
                font-size: 14px;
                gap: 10px;
                padding: 12px 16px;
            }
            
            .google-icon {
                width: 18px;
                height: 18px;
            }
        }

        @media (max-width: 360px) {
            .mobile-contact-btn {
                padding: 5px 8px;
                font-size: 12px;
                gap: 4px;
            }

            .mobile-contact-btn i {
                font-size: 12px;
            }

            .container {
                gap: 15px; /* Further reduced for smallest screens */
            }
            
            .headline {
                font-size: 2rem;
            }
            
            .subtitle {
                font-size: 1.05rem;
                margin-bottom: 15px; /* Further reduced */
            }
            
            .illustration {
                width: 260px;
                height: 180px;
                margin: 10px auto; /* Further reduced */
            }
            
            .task-card.card1 {
                width: 105px;
                top: 12px;
                left: 12px;
            }
            
            .task-card.card2 {
                width: 90px;
                top: 70px;
                right: 25px;
            }
            
            .task-card.card3 {
                width: 95px;
                bottom: 20px;
                left: 45px;
            }
            
            .task-text {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements">
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="geo-shape triangle"></div>
        <div class="geo-shape square"></div>
        <div class="geo-shape circle"></div>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            <i class="fas fa-tasks"></i>
            PRIORIFY
        </div>
        <div class="nav-menu">
            <a href="https://wa.me/message/OBDDA7FB7N7BG1" class="contact-btn" target="_blank">
                <i class="fab fa-whatsapp"></i>
                Contact Us
            </a>
        </div>
        <!-- Mobile Contact Button (Hidden on desktop) -->
        <a href="https://wa.me/message/OBDDA7FB7N7BG1" class="mobile-contact-btn" target="_blank">
            <i class="fab fa-whatsapp"></i>
            Contact Us
        </a>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <h1 class="headline">
                From <span>Chaos</span> to <span>Clarity</span>
            </h1>
            <p class="subtitle">
                Priorify helps you turn scattered tasks into a focused workflow.
            </p>
            
            <!-- Task Cards Illustration -->
            <div class="illustration">
                <div class="task-card card1">
                    <div class="task-text">Priority Task</div>
                    <div class="task-progress">
                        <div class="task-progress-fill"></div>
                    </div>
                </div>
                <div class="task-card card2">
                    <div class="task-text">In Progress</div>
                    <div class="task-progress">
                        <div class="task-progress-fill"></div>
                    </div>
                </div>
                <div class="task-card card3">
                    <div class="task-text">To Do</div>
                    <div class="task-progress">
                        <div class="task-progress-fill"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - Login Form -->
        <div class="right-section">
            <div class="login-container">
                <h2 class="login-title">Welcome to Priorify</h2>
                <p class="login-subtitle">Sign in to get started</p>

                <!-- Error/Success Messages -->
                <div id="errorMessage" class="error-message"></div>
                <div id="successMessage" class="success-message"></div>

                <!-- Google OAuth Button -->
                <a href="#" class="google-btn" onclick="handleGoogleLogin()">
                    <div class="google-icon"></div>
                    Continue with Google
                </a>
            </div>
        </div>
    </div>

    <script>
        // Handle Google OAuth login
        function handleGoogleLogin() {
            // Redirect to Google OAuth endpoint
            window.location.href = '/oauth/google';
        }
    </script>
</body>
</html>