<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priorify - Task Management Made Simple</title>
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

        /* Header - Fixed Mobile Issues */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            border-bottom: 1px solid rgba(237, 238, 235, 0.5);
            min-height: 60px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #31393c;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
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
            gap: 12px;
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

        .login-btn {
            background: #3e96f4;
            padding: 8px 14px;
            border-radius: 6px;
            color: white !important;
            transition: all 0.3s ease;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .login-btn:hover {
            background: #2c7bd4;
            transform: translateY(-1px);
            color: white !important;
        }

        .contact-btn {
            background: transparent;
            border: 1px solid #3e96f4;
            padding: 8px 14px;
            border-radius: 6px;
            color: #3e96f4 !important;
            transition: all 0.3s ease;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .contact-btn:hover {
            background: #3e96f4;
            color: white !important;
            transform: translateY(-1px);
        }

        /* Mobile contact button */
        .mobile-contact-btn {
            display: none;
        }

        /* Main container - Fixed Mobile Layout */
        .hero-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            padding: 80px 20px 40px;
            gap: 40px;
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

        /* Minimal illustration - Fixed Mobile Sizing */
        .illustration {
            position: relative;
            width: 100%;
            max-width: 300px;
            height: 200px;
            margin: 30px auto;
        }

        .task-card {
            position: absolute;
            background: white;
            border: 1px solid #edeeeb;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(49, 57, 60, 0.08);
            animation: float 6s ease-in-out infinite;
            font-size: 11px;
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
            right: 20px;
            animation-delay: -2s;
        }

        .task-card.card3 {
            width: 110px;
            bottom: 30px;
            left: 50px;
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

        /* Right section - Call to Action */
        .right-section {
            flex: 0 0 380px;
            max-width: 380px;
        }

        .cta-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(237, 238, 235, 0.8);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
            width: 100%;
        }

        .cta-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #31393c;
            margin-bottom: 16px;
        }

        .cta-subtitle {
            color: #ccc7bf;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .cta-btn {
            width: 100%;
            background: #3e96f4;
            color: white;
            border: none;
            padding: 14px 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 16px;
        }

        .cta-btn:hover {
            background: #2c7bd4;
            transform: translateY(-2px);
        }

        .cta-note {
            font-size: 12px;
            color: #ccc7bf;
        }

        /* Google OAuth Button Styling */
        .google-btn {
            width: 100%;
            background: #ffffff;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 500;
            color: #3c4043;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 16px;
        }

        .google-btn:hover {
            background: #f8f9fa;
            border-color: #c6c8ca;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .google-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .google-icon {
            width: 20px;
            height: 20px;
            background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"%3E%3Cpath fill="%23EA4335" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/%3E%3Cpath fill="%23FBBC05" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/%3E%3Cpath fill="%23EA4335" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/%3E%3Cpath fill="%2334A853" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/%3E%3C/svg%3E');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* Alternative Login Options */
        .divider {
            position: relative;
            text-align: center;
            margin: 24px 0;
            color: #ccc7bf;
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #edeeeb;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.9);
            padding: 0 16px;
        }

        .email-login-btn {
            width: 100%;
            background: transparent;
            border: 1px solid #3e96f4;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 500;
            color: #3e96f4;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .email-login-btn:hover {
            background: #3e96f4;
            color: white;
            transform: translateY(-1px);
        }

        .login-footer {
            font-size: 12px;
            color: #ccc7bf;
            margin-top: 16px;
            line-height: 1.4;
        }

        .login-footer a {
            color: #3e96f4;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Features Section */
        .features-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 80px 20px;
            position: relative;
            z-index: 10;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.4rem;
            font-weight: 700;
            color: #31393c;
            margin-bottom: 16px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: #ccc7bf;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            border: 1px solid #edeeeb;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.12);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #3e96f4;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 20px;
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #31393c;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: #ccc7bf;
            line-height: 1.6;
        }

        /* How It Works Section */
        .how-it-works {
            padding: 80px 20px;
            position: relative;
            z-index: 10;
        }

        .how-it-works-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(237, 238, 235, 0.8);
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: #3e96f4;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
            margin: 0 auto 20px;
        }

        .step-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #31393c;
            margin-bottom: 12px;
        }

        .step-desc {
            color: #ccc7bf;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: rgba(255, 255, 255, 0.95);
            padding: 60px 20px;
            position: relative;
            z-index: 10;
        }

        .stats-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3e96f4;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 1rem;
            color: #ccc7bf;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            background: rgba(49, 57, 60, 0.95);
            color: white;
            padding: 40px 20px 20px;
            position: relative;
            z-index: 10;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #3e96f4;
        }

        .footer-section p, .footer-section a {
            color: #ccc7bf;
            line-height: 1.6;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #3e96f4;
        }

        .social-links {
            display: flex;
            gap: 16px;
            margin-top: 16px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: #3e96f4;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #2c7bd4;
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(237, 238, 235, 0.2);
            padding-top: 20px;
            text-align: center;
            color: #ccc7bf;
            font-size: 14px;
        }

        /* Mobile Responsive Design - Comprehensive Fix */
        @media (max-width: 1024px) {
            .header {
                padding: 15px 20px;
            }

            .hero-container {
                flex-direction: column;
                gap: 40px;
                padding: 100px 20px 40px;
                text-align: center;
            }

            .left-section {
                max-width: 100%;
            }

            .right-section {
                flex: none;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }

            .headline {
                font-size: 2.5rem;
            }

            .subtitle {
                font-size: 1.1rem;
            }

            .illustration {
                max-width: 350px;
                height: 240px;
            }

            .features-section, .how-it-works, .stats-section {
                padding: 60px 20px;
            }

            .section-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 12px 15px;
            }

            .logo {
                font-size: 15px;
            }

            .nav-menu {
                gap: 8px;
            }

            .nav-menu a {
                display: none;
            }

            .login-btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .contact-btn {
                display: none;
            }

            .mobile-contact-btn {
                display: flex;
                align-items: center;
                background: transparent;
                border: 1px solid #3e96f4;
                padding: 8px 12px;
                border-radius: 6px;
                color: #3e96f4;
                text-decoration: none;
                font-size: 12px;
                font-weight: 500;
                gap: 6px;
                transition: all 0.3s ease;
                white-space: nowrap;
            }

            .mobile-contact-btn:hover {
                background: #3e96f4;
                color: white;
                transform: translateY(-1px);
            }

            .hero-container {
                padding: 80px 15px 20px;
                gap: 30px;
            }

            .headline {
                font-size: 2.2rem;
                margin-bottom: 16px;
            }

            .subtitle {
                font-size: 1.05rem;
                margin-bottom: 25px;
            }

            .illustration {
                max-width: 300px;
                height: 200px;
            }

            .task-card.card1 {
                width: 110px;
                top: 15px;
                left: 15px;
            }

            .task-card.card2 {
                width: 95px;
                top: 70px;
                right: 15px;
            }

            .task-card.card3 {
                width: 100px;
                bottom: 25px;
                left: 40px;
            }

            .cta-container {
                padding: 24px 20px;
            }

            .cta-title {
                font-size: 1.4rem;
            }

            .cta-btn, .google-btn, .email-login-btn {
                padding: 12px 16px;
                font-size: 14px;
            }

            .section-title {
                font-size: 1.9rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .feature-card {
                padding: 24px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 10px 12px;
            }

            .logo {
                font-size: 14px;
            }

            .login-btn, .mobile-contact-btn {
                padding: 6px 10px;
                font-size: 11px;
                gap: 4px;
            }

            .hero-container {
                padding: 70px 12px 15px;
                gap: 25px;
            }

            .headline {
                font-size: 2rem;
                margin-bottom: 14px;
            }

            .subtitle {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .illustration {
                max-width: 280px;
                height: 180px;
            }

            .task-card {
                padding: 10px;
                border-radius: 6px;
            }

            .task-card.card1 {
                width: 100px;
                top: 10px;
                left: 10px;
            }

            .task-card.card2 {
                width: 85px;
                top: 60px;
                right: 10px;
            }

            .task-card.card3 {
                width: 90px;
                bottom: 20px;
                left: 35px;
            }

            .task-text {
                font-size: 10px;
                margin-bottom: 5px
            }

            .cta-container {
                padding: 24px 20px;
                margin: 0 5px;
            }

            .cta-title {
                font-size: 1.4rem;
            }

            .cta-subtitle {
                margin-bottom: 20px;
            }

            .cta-btn {
                font-size: 14px;
                gap: 8px;
                padding: 12px 16px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .features-grid {
                gap: 30px;
            }

            .feature-card {
                padding: 24px;
            }
        }

        @media (max-width: 360px) {
            .login-btn, .mobile-contact-btn {
                padding: 4px 8px;
                font-size: 11px;
                gap: 3px;
            }

            .hero-container {
                gap: 15px;
            }

            .headline {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1.05rem;
                margin-bottom: 15px;
            }

            .illustration {
                width: 260px;
                height: 180px;
                margin: 10px auto;
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
            <a href="#" class="login-btn" onclick="scrollToLogin()">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
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

    <!-- Hero Section -->
    <div class="hero-container">
        <!-- Left Section -->
        <div class="left-section">
            <h1 class="headline">
                From <span>Chaos</span> to <span>Clarity</span>
            </h1>
            <p class="subtitle">
                Priorify helps you turn scattered tasks into a focused workflow. Organize, prioritize, and achieve your goals with intelligent task management.
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

        <!-- Right Section - Call to Action -->
        <div class="right-section">
            <div class="cta-container">
                <h2 class="cta-title">Ready to Get Organized?</h2>
                <p class="cta-subtitle">Join thousands of users who have transformed their productivity</p>
                <button class="cta-btn" onclick="scrollToLogin()">Get Started Free</button>
                <p class="cta-note">No credit card required</p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="features-container">
            <h2 class="section-title">Why Choose Priorify?</h2>
            <p class="section-subtitle">
                Experience the power of intelligent task management with features designed to boost your productivity
            </p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sort-amount-up"></i>
                    </div>
                    <h3 class="feature-title">Smart Prioritization</h3>
                    <p class="feature-desc">
                        Automatically organize your tasks by importance and urgency. Focus on what matters most with our intelligent priority system.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Deadline Management</h3>
                    <p class="feature-desc">
                        Never miss a deadline again. Set due dates, get reminders, and track your progress with visual timelines.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-border-all"></i>
                    </div>
                    <h3 class="feature-title">Board Columns</h3>
                    <p class="feature-desc">
                        Move tasks between columns (To Do, In Progress, Completed) with just drag & drop — fast, intuitive, and efficient, like using a physical board but in digital form!
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Progress Tracking</h3>
                    <p class="feature-desc">
                        Monitor your productivity with detailed analytics. See what's working and optimize your workflow.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mobile Ready</h3>
                    <p class="feature-desc">
                        Access your tasks anywhere, anytime. Fully responsive design works perfectly on all devices.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Secure & Reliable</h3>
                    <p class="feature-desc">
                        Your data is protected with enterprise-grade security. Reliable cloud sync keeps everything safe.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="how-it-works">
        <div class="how-it-works-container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">
                Get started in minutes with our simple 3-step process
            </p>
            
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Add Your Tasks</h3>
                    <p class="step-desc">
                        Simply add your tasks, projects, and ideas. Use natural language to describe what needs to be done.
                    </p>
                </div>
                
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Set Priorities</h3>
                    <p class="step-desc">
                        Our smart algorithm helps you prioritize based on deadlines, importance, and your personal goals.
                    </p>
                </div>
                
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Get Things Done</h3>
                    <p class="step-desc">
                        Focus on your prioritized tasks and watch your productivity soar. Track progress and celebrate wins.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">1M+</div>
                    <div class="stat-label">Tasks Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">User Satisfaction</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Support Available</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Section -->
    <div id="login-section" class="features-section">
        <div class="features-container">
            <h2 class="section-title">Start Your Journey</h2>
            <p class="section-subtitle">
                Join Priorify today and transform the way you work
            </p>
            
            <div style="max-width: 400px; margin: 0 auto; align-items:center;">
                <div class="cta-container">
                    <h2 class="cta-title">Welcome to Priorify</h2>
                    <p class="cta-subtitle">Sign in to get started</p>

                    <!-- Error/Success Messages -->
                    <div id="errorMessage" style="background: #fee; color: #c53030; padding: 12px; border-radius: 8px; margin-bottom: 20px; display: none; font-size: 14px; text-align: center;"></div>
                    <div id="successMessage" style="background: #f0f9ff; color: #0369a1; padding: 12px; border-radius: 8px; margin-bottom: 20px; display: none; font-size: 14px; text-align: center;"></div>

                    <!-- Google OAuth Button -->
                    <button class="cta-btn" onclick="handleGoogleLogin()" style="display: flex; align-items: center; justify-content: center; gap: 12px; background: white; color: #31393c; border: 1px solid #edeeeb;">
                        <div style="width: 20px; height: 20px; background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22%3E%3Cpath fill=%22%234285F4%22 d=%22M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z%22/%3E%3Cpath fill=%22%2334A853%22 d=%22M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z%22/%3E%3Cpath fill=%22%23FBBC05%22 d=%22M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z%22/%3E%3Cpath fill=%22%23EA4335%22 d=%22M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z%22/%3E%3C/svg%3E'); background-size: cover;"></div>
                        Continue with Google
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Priorify</h3>
                    <p>Transform your productivity with intelligent task management. From chaos to clarity, we help you focus on what matters most.</p>
                    <div class="social-links">
                        <a href="https://instagram.com/clawnzl" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://github.com/nabilagp" target="_blank">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Features</h3>
                    <p><a href="#">Smart Prioritization</a></p>
                    <p><a href="#">Deadline Management</a></p>
                    <p><a href="#">Board-Columns Drag and Drop</a></p>
                    <p><a href="#">Progress Tracking</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Support</h3>
                    <p><a href="#">Help Center</a></p>
                    <p><a href="#">Contact Support</a></p>
                    <p><a href="https://wa.me/message/OBDDA7FB7N7BG1" target="_blank">WhatsApp Support</a></p>
                    <p><a href="#">Documentation</a></p>
                </div>
                
                <div class="footer-section">
                    <h3>Company</h3>
                    <p><a href="#">About Us</a></p>
                    <p><a href="#">Privacy Policy</a></p>
                    <p><a href="#">Terms of Service</a></p>
                    <p><a href="#">Blog</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Priorify. All rights reserved. Created by <strong>Nabila Gusniar Putri</strong></p>
            </div>
        </div>
    </div>

    <script>
        // Handle Google OAuth login
        function handleGoogleLogin() {
            // Redirect to Google OAuth endpoint
            window.location.href = '/oauth/google';
        }

        // Scroll to login section
        function scrollToLogin() {
            document.getElementById('login-section').scrollIntoView({ 
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Add smooth scrolling for better user experience
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effects for better interactivity
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 20px rgba(49, 57, 60, 0.1)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.85)';
                header.style.boxShadow = 'none';
            }
        });

        // Add animation on scroll for feature cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all feature cards and step cards
        document.querySelectorAll('.feature-card, .step-card, .stat-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>
