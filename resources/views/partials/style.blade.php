<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Board</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #3e96f4 0%, #31393c 100%);
            --secondary-gradient: linear-gradient(135deg, #31393c 0%, #ccc7bf 100%);
            --accent-gradient: linear-gradient(135deg, #3e96f4 0%, #edeeeb 100%);
            --success-gradient: linear-gradient(135deg, #3e96f4 0%, #ffffff 100%);
            --warning-gradient: linear-gradient(135deg, #ccc7bf 0%, #31393c 100%);
            --neutral-gradient: linear-gradient(135deg, #edeeeb 0%, #ffffff 100%);
            --dark-gradient: linear-gradient(135deg, #31393c 0%, #ccc7bf 100%);
            --glass-bg: rgba(237, 238, 235, 0.8);
            --glass-border: rgba(204, 199, 191, 0.5);
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #31393c 50%, #3e96f4 100%);
            background-size: 400% 400%;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(62, 150, 244, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(49, 57, 60, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(204, 199, 191, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .menu {
            display: flex;
            gap: 24px;
            padding: 12px 24px;
            border-bottom: 1px solid var(--glass-border);
            width: 100%;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 0 0 20px 20px;
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
            overflow-x: auto;
            white-space: nowrap;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #31393c;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 12px 16px;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(62, 150, 244, 0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .menu-item:hover::before {
            transform: translateX(100%);
        }

        .menu-item:hover {
            color: #31393c;
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(49, 57, 60, 0.15);
        }

        .menu-item a {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1;
            position: relative;
        }

        .menu-item img {
            width: 22px;
            height: 22px;
            opacity: 0.8;
            filter: drop-shadow(0 2px 4px rgba(49, 57, 60, 0.1));
            transition: all 0.3s ease;
        }

        .menu-item.active {
            color: #ffffff;
            background: var(--primary-gradient);
            box-shadow: 0 8px 25px rgba(62, 150, 244, 0.4);
        }

        .menu-item.active img {
            opacity: 1;
            transform: scale(1.1);
        }

        .menu-item.user {
            margin-left: auto;
            font-weight: 600;
        }

        .board {
            display: flex;
            gap: 24px;
            margin-top: 24px;
            padding: 0 24px 16px;
            width: 100%;
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .board-wrapper {
            display: flex;
            height: calc(100vh - 120px);
            overflow-x: auto;
            gap: 20px;
            padding: 0;
            width: 100%;
        }

        .column {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            padding: 20px;
            border-radius: 20px;
            flex: 1;
            min-width: 300px;
            max-width: calc(25% - 20px);
            min-height: 300px;
            position: relative;
            color: #31393c;
            overflow: visible;
            flex-shrink: 0;
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .column:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(49, 57, 60, 0.2);
            background: rgba(255, 255, 255, 0.9);
        }

        .column-tasks {
            flex: 1;
            overflow-y: hidden;
            margin-bottom: 12px;
            padding-right: 8px;
        }

        .column:hover .column-tasks {
            overflow-y: auto;
        }

        .column-tasks::-webkit-scrollbar {
            width: 8px;
        }

        .column-tasks::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, rgba(204, 199, 191, 0.5) 0%, rgba(204, 199, 191, 0.3) 100%);
            border-radius: 10px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .column-tasks::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, rgba(204, 199, 191, 0.7) 0%, rgba(204, 199, 191, 0.5) 100%);
            background-clip: content-box;
        }

        .column-tasks::-webkit-scrollbar-track {
            background: rgba(204, 199, 191, 0.2);
            border-radius: 10px;
        }

        .column h2 {
            font-weight: 700;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 4px rgba(49, 57, 60, 0.1);
            color: #31393c;
        }

        .completed-task {
            text-decoration: line-through;
            opacity: 0.6;
            filter: grayscale(0.5);
        }

        .task {
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            margin-bottom: 12px;
            padding: 16px;
            border-left: 4px solid;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1; 
            cursor: grab;
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #31393c;
            position: relative;
            overflow: hidden;
            width: 100%;
            word-wrap: break-word;
            word-break: break-word;
        }

        .task::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(62, 150, 244, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .task:hover::before {
            left: 100%;
        }

        .task:hover {
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 8px 32px rgba(49, 57, 60, 0.2);
            transform: translateY(-4px) scale(1.02);
            border-left-width: 6px;
        }

        .task:nth-child(even) {
            border-left-color: #3e96f4;
        }

        .task:nth-child(odd) {
            border-left-color: #31393c;
        }

        .task:nth-child(3n) {
            border-left-color: #ccc7bf;
        }

        .dragging {
            opacity: 0.7;
            transform: rotate(5deg) scale(1.05);
            box-shadow: 0 16px 48px rgba(49, 57, 60, 0.3);
            z-index: 1000;
        }

        .drop-target {
            background: rgba(62, 150, 244, 0.2);
            border: 2px dashed rgba(62, 150, 244, 0.6);
        }

        .column button.create-btn {
            display: none;
            margin-top: 16px;
            background: var(--accent-gradient);
            padding: 14px;
            border-radius: 16px;
            width: 100%;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            color: #31393c;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(62, 150, 244, 0.3);
            position: relative;
            overflow: hidden;
        }

        .column button.create-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .column button.create-btn:hover::before {
            transform: translateX(100%);
        }

        .column button.create-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(62, 150, 244, 0.4);
        }

        .column.to-do button.create-btn,
        .column:not(.to-do):hover button.create-btn {
            display: block;
        }

        .menu-container {
            position: relative;
            z-index: 999999;
            overflow: visible; 
        }

        .menu-button {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #31393c;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 12px;
        }

        .menu-button:hover {
            color: #3e96f4;
            background: rgba(255, 255, 255, 0.8);
            transform: rotate(180deg);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(49, 57, 60, 0.2);
            min-width: 150px;
            max-width: 160px;
            z-index: 9999999;
            transform: translateY(8px);
            overflow: visible;
        }

        .dropdown-menu div,
        .dropdown-menu button,
        .dropdown-menu a {
            padding: 14px 18px;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            text-decoration: none;
            color: #31393c;
            display: block;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-menu div:hover,
        .dropdown-menu button:hover,
        .dropdown-menu a:hover {
            background: rgba(62, 150, 244, 0.1);
            transform: translateX(4px);
            color: #31393c;
        }

        .dropdown-menu .delete {
            color: #d32f2f;
            font-weight: 600;
        }

        .dropdown-menu .delete:hover {
            background: rgba(211, 47, 47, 0.1);
            color: #d32f2f;
        }

        #taskModal,
        #confirmDeleteModal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(49, 57, 60, 0.5);
            backdrop-filter: blur(10px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }

        #taskModal.active,
        #confirmDeleteModal.active {
            display: flex;
        }

        #taskModal > div,
        #confirmDeleteModal > div {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            padding: 32px;
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 24px 64px rgba(49, 57, 60, 0.3);
            text-align: center;
            border: 1px solid var(--glass-border);
            color: #31393c;
            overflow-x: hidden;
        }

        .modal-form input[type="text"],
        .modal-form input[type="title"] {
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            margin-bottom: 16px;
            padding: 14px 18px;
            border: 2px solid var(--glass-border);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
            color: #31393c;
        }

        .modal-form input::placeholder {
            color: rgba(49, 57, 60, 0.6);
        }

        .modal-form input[type="date"],
        .modal-form select {
            width: 100%;
            margin-bottom: 16px;
            padding: 14px 18px;
            border: 2px solid var(--glass-border);
            border-radius: 16px;
            font-size: 15px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Inter', sans-serif;
            color: #31393c;
        }

        .modal-form {
            overflow-x: hidden;
        }

        .modal-form input:focus,
        .modal-form select:focus {
            outline: none;
            border-color: #3e96f4;
            box-shadow: 0 0 0 4px rgba(62, 150, 244, 0.1);
            background: rgba(255, 255, 255, 1);
        }

        .modal-add-button {
            padding: 14px 28px;
            background: var(--primary-gradient);
            color: #ffffff;
            border-radius: 16px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(62, 150, 244, 0.3);
            margin-right: 0;
            position: relative;
            overflow: hidden;
        }

        .modal-add-button::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .modal-add-button:hover::before {
            transform: translateX(100%);
        }

        .modal-add-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(62, 150, 244, 0.4);
        }

        .modal-cancel-button {
            padding: 14px 28px;
            background: rgba(204, 199, 191, 0.8);
            backdrop-filter: blur(10px);
            color: #31393c;
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-cancel-button:hover {
            background: rgba(204, 199, 191, 1);
            transform: translateY(-2px);
        }

        #cancelDeleteBtn {
            background: rgba(204, 199, 191, 0.8);
            backdrop-filter: blur(10px);
            color: #31393c;
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-right: 12px;
        }

        #cancelDeleteBtn:hover {
            background: rgba(204, 199, 191, 1);
            transform: translateY(-2px);
        }

        #confirmDeleteBtn {
            background: linear-gradient(135deg, #d32f2f 0%, #f44336 100%);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            padding: 14px 28px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(211, 47, 47, 0.3);
        }

        #confirmDeleteBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(211, 47, 47, 0.4);
        }

        .logout {
            margin-left: auto;
            background: rgba(211, 47, 47, 0.1);
            border-radius: 12px;
            padding: 4px;
        }

        .logout a {
            text-decoration: none;
            color: #d32f2f;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 10px 16px;
            border-radius: 8px;
            display: block;
        }

        .logout a:hover {
            color: #ffffff;
            background: #d32f2f;
            transform: translateY(-2px);
        }

.header {
    /* Ensure header is at the very top and spans full width */
    position: sticky; /* Keeps it at the top when scrolling */
    top: 0;
    z-index: 1000; /* High z-index to ensure it's above other content */
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border-top: 4px solid transparent;
    border-image: var(--primary-gradient) 1;
    padding: 16px 24px;
    border-bottom: 1px solid var(--glass-border);
    width: 100%;
    height: 70px;
    box-shadow: 0 4px 20px rgba(49, 57, 60, 0.1);
}

        .logo-title {
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 44px;
            border-radius: 12px;
            margin-right: 14px;
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.1);
            filter: drop-shadow(0 2px 4px rgba(49, 57, 60, 0.1));
        }

        .title h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #31393c;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 4px rgba(49, 57, 60, 0.1);
        }

        .title span {
            font-size: 13px;
            color: rgba(49, 57, 60, 0.7);
            font-weight: 500;
        }

.profile-container {
    /* Ensure profile is positioned correctly relative to the header */
    position: relative;
    display: inline-block;
    z-index: 1001; /* Higher than header's general content */
}

        .profile-circle {
            width: 36px;
            height: 36px;
            background: var(--primary-gradient);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            z-index: 1002;
            position: relative;
            justify-content: center;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
            font-size: 16px;
            box-shadow: 0 4px 16px rgba(62, 150, 244, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--glass-border);
        }

        .profile-circle:hover {
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 8px 25px rgba(62, 150, 244, 0.4);
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 55px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            min-width: 220px;
            box-shadow: 0 16px 48px rgba(49, 57, 60, 0.2);
            z-index: 1002;
            overflow: hidden;
        }

        .profile-dropdown .profile-info {
            padding: 20px;
            border-bottom: 1px solid var(--glass-border);
            background: rgba(62, 150, 244, 0.05);
            font-size: 14px;
            font-weight: 500;
            color: #31393c;
            z-index: 1002;
        }

        .profile-dropdown a {
            display: block;
            padding: 16px 20px;
            color: #31393c;
            text-decoration: none;
            font-weight: 500;
            
            transition: all 0.2s ease;
        }

        .profile-dropdown a:hover {
            background: rgba(62, 150, 244, 0.1);
            transform: translateX(4px);
        }

        .status-overview {
            min-width: 220px;
            padding: 24px;
            font-size: 15px;
            text-align: center;
            border-right: 2px solid var(--glass-border);
            position: relative;
            z-index: 10;
        }

        .status-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 16px;
            box-shadow: 0 4px 16px rgba(49, 57, 60, 0.1);
            color: #31393c;
            position: relative;
            overflow: hidden;
        }

        .status-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(62, 150, 244, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .status-box:hover::before {
            left: 100%;
        }

        .status-box:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 32px rgba(49, 57, 60, 0.2);
        }

        .status-box:nth-child(1) { border-left: 4px solid #3e96f4; }
        .status-box:nth-child(2) { border-left: 4px solid #31393c; }
        .status-box:nth-child(3) { border-left: 4px solid #ccc7bf; }
        .status-box:nth-child(4) { border-left: 4px solid #edeeeb; }

        .status-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: #31393c;
            letter-spacing: -0.01em;
        }

        .status-count {
            font-size: 1.8em;
            font-weight: 800;
            color: #31393c;
            text-shadow: 0 2px 4px rgba(49, 57, 60, 0.2);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .column {
            animation: fadeInUp 0.8s ease-out;
        }

        .task {
            animation: fadeInUp 0.6s ease-out;
        }

        .menu-item {
            animation: slideInRight 0.7s ease-out;
        }

        .status-box {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Stagger animations */
        .column:nth-child(1) { animation-delay: 0.1s; }
        .column:nth-child(2) { animation-delay: 0.2s; }
        .column:nth-child(3) { animation-delay: 0.3s; }
        .column:nth-child(4) { animation-delay: 0.4s; }

        .menu-item:nth-child(1) { animation-delay: 0.1s; }
        .menu-item:nth-child(2) { animation-delay: 0.2s; }
        .menu-item:nth-child(3) { animation-delay: 0.3s; }
        .menu-item:nth-child(4) { animation-delay: 0.4s; }

        .status-box:nth-child(1) { animation-delay: 0.1s; }
        .status-box:nth-child(2) { animation-delay: 0.2s; }
        .status-box:nth-child(3) { animation-delay: 0.3s; }
        .status-box:nth-child(4) { animation-delay: 0.4s; }

        /* Mobile Responsive */

  /* Responsive adjustments */
/* --- Mobile Responsive Adjustments --- */
@media (max-width: 768px) {
    /* Adjust body padding for smaller screens */
    body {
        padding-top: 0; /* Remove top padding if header becomes static */
    }

    /* Header adjustments for smaller screens */
    .header {
        flex-direction: column; /* Stack logo and profile */
        align-items: flex-start;
        height: auto;
        padding: 12px 20px; /* Adjust padding */
        position: sticky; /* Make header sticky */
        top: 0;
        z-index: 1000;
        border-radius: 0 0 20px 20px; /* Maintain rounded bottom */
    }

    .logo-title {
        margin-bottom: 10px; /* Space between logo and title */
    }

    .profile-container {
        width: 100%;
        display: flex;
        justify-content: flex-end; /* Align profile to the right */
        margin-top: -40px; /* Overlap with logo-title slightly */
        padding-right: 5px;
    }

    .profile-dropdown {
        top: 45px; /* Adjust dropdown position relative to profile circle */
        right: 0;
        left: auto;
        min-width: unset; /* Remove min-width */
        width: 180px; /* Set a specific width for mobile dropdown */
    }

    /* Menu adjustments for mobile */
    .menu {
        padding: 10px 16px; /* Smaller padding */
        gap: 16px; /* Smaller gap */
        border-radius: 0; /* Remove border-radius if not needed */
        justify-content: flex-start; /* Align items to start */
    }

    .menu-item {
        padding: 8px 12px; /* Smaller padding for menu items */
        font-size: 12px; /* Smaller font size */
        gap: 4px; /* Smaller gap for icon and text */
        border-radius: 12px; /* Adjust border-radius */
    }

    .menu-item img {
        width: 18px; /* Smaller icons */
        height: 18px;
    }

    /* Board and Column adjustments */
    .board-wrapper {
        flex-direction: column; /* Ini akan menumpuk status-overview dan board */
        height: auto; /* Membiarkan tinggi menyesuaikan konten */
        overflow-x: hidden; /* Menghilangkan scroll horizontal pada wrapper */
        padding: 20px; /* Menambahkan padding di sisi wrapper */
    }

    .board {
        flex-direction: column; /* Membuat kolom-kolom (To Do, In Progress, Completed) menjadi vertikal */
        gap: 20px; /* Menambahkan jarak antar kolom */
        overflow-x: hidden; /* Menghilangkan scroll horizontal jika ada */
        padding: 0; /* Sesuaikan padding jika perlu */
    }

    .column {
        min-width: unset; /* Menghapus lebar minimum */
        max-width: 100%; /* Mengambil lebar penuh */
        margin-bottom: 0; /* Menghilangkan margin-bottom karena gap sudah menangani */
        height: auto; /* Membiarkan tinggi kolom menyesuaikan */
        min-height: unset; /* Menghapus tinggi minimum untuk kolom */
        flex-shrink: 1; /* Memungkinkan kolom untuk menyusut */
    }
    .column-tasks {
        overflow-y: auto; /* Selalu aktifkan scroll vertikal untuk tugas di mobile */
        max-height: 400px; /* Batasi tinggi daftar tugas agar tidak terlalu panjang */
        padding-right: 0; /* Menghapus padding kanan agar scrollbar tidak terpotong */
    }

    .column h2 {
        font-size: 18px; /* Slightly smaller column titles */
        margin-bottom: 15px; /* Adjust margin */
    }

    /* --- Perubahan Utama untuk Status Overview --- */
    .status-overview {
        min-width: unset; /* Menghapus lebar minimum */
        padding: 20px; /* Menyesuaikan padding */
        border-right: none; /* Menghapus border kanan */
        border-bottom: 2px solid var(--glass-border); /* Menambahkan border bawah */
        margin-bottom: 20px;
        display: grid; /* Menggunakan Grid */
        /* KUNCI: Membuat hanya satu kolom untuk menumpuk kotak-kotak status */
        grid-template-columns: 1fr; /* Setiap kotak status akan mengambil lebar penuh dan menumpuk */
        gap: 15px; /* Jarak antar status box */
    }

    .status-overview h3 {
        display: block; /* Pastikan judul terlihat */
        text-align: center; /* Opsional: Pusatkan judul */
        margin-bottom: 15px; /* Tambahkan sedikit ruang di bawah judul */
        font-size: 1.2em; /* Sesuaikan ukuran font judul jika perlu */
        color: #31393c; /* Warna teks sesuai tema */
    }

    /* Jika Anda memiliki kontainer terpisah untuk kotak status seperti .status-boxes-container,
       terapkan grid di sana, dan pastikan .status-overview hanya sebagai pembungkus:
    .status-boxes-container {
        display: grid;
        grid-template-columns: 1fr; // Pastikan ini juga 1fr jika kontainer ini ada
        gap: 15px;
    }
    */

    .status-box {
        padding: 15px; /* Smaller padding */
        border-radius: 16px; /* Adjust border-radius */
        font-size: 14px; /* Smaller font size */
        margin-bottom: 0; /* Remove default margin */
        text-align: center; /* Pusatkan teks di dalam kotak */
    }

    .status-title {
        font-size: 14px; /* Adjust title font size */
        margin-bottom: 8px;
    }

    .status-count {
        font-size: 1.5em; /* Adjust count font size */
    }
    /* --- Akhir Perubahan Utama --- */


    .task {
        padding: 12px; /* Smaller padding for tasks */
        font-size: 13px; /* Smaller font size for tasks */
        margin-bottom: 10px; /* Adjust margin */
        text-align: left;
        display: flex;
        flex-direction: row; /* Membuat item sejajar horizontal */
        justify-content: space-between; /* Mendorong judul ke kiri, tombol ke kanan */
        align-items: center; /* Menyusun item di tengah secara vertikal */

    }

    .task .task-title { /* Assuming you have a span/div for task title */
        width: 100%; /* Ensure title takes full width */
        flex-grow: 1;
        word-wrap: break-word; /* Ensure long words break */
        word-break: break-word;
        margin-right: 8px; /* Jarak antara judul dan tombol */
        margin-bottom: 0;
    }

    /* Modal adjustments for smaller screens */
    #taskModal > div,
    #confirmDeleteModal > div {
        padding: 24px; /* Smaller padding for modals */
        border-radius: 16px; /* Adjust border-radius */
    }

    .modal-form input,
    .modal-form select {
        padding: 12px 16px; /* Smaller padding for form inputs */
        font-size: 14px; /* Smaller font size */
        border-radius: 12px; /* Adjust border-radius */
    }

    .modal-add-button,
    .modal-cancel-button,
    #cancelDeleteBtn,
    #confirmDeleteBtn {
        padding: 12px 20px; /* Smaller button padding */
        font-size: 14px; /* Smaller button font size */
        border-radius: 12px; /* Adjust button border-radius */
        margin-bottom: 10px; /* Add margin for stacked buttons */
        width: 100%; /* Make buttons full width */
    }

    #cancelDeleteBtn {
        margin-right: 0; /* Remove right margin when stacked */
    }

    /* Make the menu button more prominent and ensure it's on top */
    .menu-button {
        position: relative; /* Important for z-index context */
        z-index: 10; /* Ensure the button is above other task content */
        background: none;
        border: none;
        font-size: 22px; /* Maintain readable size */
        cursor: pointer;
        color: #31393c;
        transition: all 0.3s ease;
        padding: 6px;
        border-radius: 12px;
    }

    .menu-container {
        flex-shrink: 0; /* Pastikan tombol tidak menyusut */
        margin-left: 0; /* Hapus margin auto dari desktop */
    }

    .menu-button:hover { /* Keep hover effects for devices that support it */
        color: #3e96f4;
        background: rgba(255, 255, 255, 0.8);
        transform: rotate(180deg);
    }

    /* Position the dropdown menu correctly and ensure it's visible */
    .dropdown-menu {
        display: none; /* Controlled by JS, but ensure default is hidden */
        position: absolute;
        top: 0; /* Position relative to the top of its parent (.menu-container) */
        right: 0; /* Align to the right of its parent */
        background: rgba(255, 255, 255, 0.98); /* Slightly less transparent for readability */
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 8px; 
        font-size: 13px;
        box-shadow: 0 8px 24px rgba(49, 57, 60, 0.25); /* Adjusted shadow for visibility */
        min-width: 120px; /* Make it a bit wider for touch */
        max-width: 140px;
        z-index: 100; /* Extremely high z-index to be on top of everything */
        transform: translateY(8px); /* Initial offset, controlled by JS for animation */
        overflow: hidden; /* Ensures rounded corners */
    }

    .dropdown-menu.show { /* Assuming you toggle a 'show' class with JS */
        display: block;
    }

    .dropdown-menu div,
    .dropdown-menu button,
    .dropdown-menu a {
        padding: 10px 14px; /* Slightly more padding for easier touch */
        font-size: 13px; /* Larger font size for readability */
    }
}

  
</style>