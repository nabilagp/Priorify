@extends('layout.app')
@section('title', 'Priorify - Calendar')

@section('content')
@include('partials.header')
@include('partials.menu')

<meta charset="UTF-8">
<title>Kalender Laravel</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- FullCalendar CDN -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

<style>
    .modal {
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease-out;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        background: white;
        padding: 32px;
        border-radius: 16px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease-out;
        position: relative;
        margin: 0;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }

    /* Event Detail Modal - Centered for Desktop */
#eventModal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(49, 57, 60, 0.7);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.3s ease-out;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

#eventModal .modal-content {
    background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
    padding: 28px;
    border-radius: 16px;
    width: 100%;
    max-width: 320px;
    box-shadow: 
        0 20px 40px rgba(49, 57, 60, 0.15),
        0 8px 16px rgba(49, 57, 60, 0.1);
    border: 1px solid rgba(204, 199, 191, 0.2);
    animation: slideIn 0.3s ease-out;
    position: relative;
    margin: 0;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
}

#eventModal .modal-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #3e96f4, #5ba4f6);
    border-radius: 16px 16px 0 0;
}

#eventModal .modal-content h3 {
    color: #31393c;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 16px;
    margin-top: 0;
    padding-right: 30px;
}

#eventModal .modal-content p {
    color: #31393c;
    margin-bottom: 12px;
    line-height: 1.5;
}

#eventModal .modal-content strong {
    color: #3e96f4;
    font-weight: 600;
}

#eventModal .close {
    color: #ccc7bf;
    float: right;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    line-height: 1;
    position: absolute;
    right: 20px;
    top: 20px;
    z-index: 1;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: transparent;
}

#eventModal .close:hover {
    color: #31393c;
    transform: scale(1.1);
    background: rgba(204, 199, 191, 0.1);
}

    .close {
        color: #999;
        float: right;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s ease;
        line-height: 1;
        position: absolute;
        right: 20px;
        top: 20px;
        z-index: 1;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: transparent;
    }

    .close:hover {
        color: #333;
        transform: scale(1.1);
        background: rgba(0, 0, 0, 0.05);
    }

    .fc-day-today {
        background: linear-gradient(135deg, rgba(62, 150, 244, 0.1), rgba(62, 150, 244, 0.05)) !important;
        border: 2px solid rgba(62, 150, 244, 0.3) !important;
    }

    .scroll-area {
        height: calc(100vh - 150px);
        overflow-y: auto;
        padding: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
    }

    #calendar {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 
            0 10px 30px rgba(49, 57, 60, 0.1),
            0 4px 12px rgba(49, 57, 60, 0.05);
        border: 1px solid rgba(204, 199, 191, 0.2);
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }

    #calendar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(62, 150, 244, 0.3), transparent);
    }

    header, .tabs {
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }

    /* FullCalendar Customization */
    .fc-header-toolbar {
        background: linear-gradient(135deg, #ffffff, #edeeeb);
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 1px solid rgba(204, 199, 191, 0.2);
        box-shadow: 0 2px 8px rgba(49, 57, 60, 0.05);
    }

    .fc-button {
        background: linear-gradient(135deg, #3e96f4, #5ba4f6) !important;
        border: none !important;
        color: white !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 8px rgba(62, 150, 244, 0.3) !important;
    }

    .fc-button:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 16px rgba(62, 150, 244, 0.4) !important;
    }

    .fc-button:active {
        transform: translateY(0) !important;
    }

    .fc-button-primary:disabled {
        background: #ccc7bf !important;
        color: white !important;
        box-shadow: none !important;
    }

    .fc-toolbar-title {
        color: #31393c !important;
        font-weight: 600 !important;
        font-size: 24px !important;
    }

    .fc-col-header-cell {
        background: linear-gradient(135deg, #edeeeb, #ffffff) !important;
        border: 1px solid rgba(204, 199, 191, 0.3) !important;
        color: #31393c !important;
        font-weight: 600 !important;
        padding: 12px 8px !important;
    }

    .fc-daygrid-day {
        transition: all 0.3s ease !important;
        border: 1px solid rgba(204, 199, 191, 0.2) !important;
        background: rgba(255, 255, 255, 0.8) !important;
    }

    .fc-daygrid-day:hover {
        background: linear-gradient(135deg, #edeeeb, rgba(62, 150, 244, 0.1)) !important;
        cursor: pointer;
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(62, 150, 244, 0.2);
        border-color: rgba(62, 150, 244, 0.3) !important;
    }

    .fc-daygrid-day-number {
        color: #31393c !important;
        font-weight: 500 !important;
        padding: 8px !important;
        transition: all 0.3s ease !important;
    }

    .fc-day-other .fc-daygrid-day-number {
        color: #ccc7bf !important;
    }

    .fc-daygrid-day:hover .fc-daygrid-day-number {
        color: #3e96f4 !important;
        font-weight: 600 !important;
    }

    .fc-event {
        padding: 6px 8px !important;
        margin: 2px !important;
        font-size: 12px !important;
        line-height: 1.3 !important;
        border-radius: 8px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        border: none !important;
        box-shadow: 0 2px 4px rgba(49, 57, 60, 0.1) !important;
        font-weight: 500 !important;
    }

    .fc-event:hover {
        transform: translateY(-2px) scale(1.05) !important;
        box-shadow: 0 8px 16px rgba(49, 57, 60, 0.2) !important;
        cursor: pointer;
        z-index: 10 !important;
    }

    .fc-event-title {
        color: black !important;
        font-weight: 600 !important;
    }

    /* Custom event colors */
    .fc-event[style*="red"] {
        background: linear-gradient(135deg, #ff6b6b, #ff5252) !important;
    }

    .fc-event[style*="yellow"] {
        background: linear-gradient(135deg, #ffd93d, #ffb74d) !important;
    }

    .fc-event[style*="green"] {
        background: linear-gradient(135deg, #51cf66, #69f0ae) !important;
    }

    .fc-event[style*="blue"] {
        background: linear-gradient(135deg, #3e96f4, #5ba4f6) !important;
    }

    /* Task Modal Styling - MODERN DESIGN */
    #taskModal {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(8px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-out;
        padding: 20px;
        box-sizing: border-box;
    }

    #taskModal > div {
        background: white;
        padding: 32px;
        border-radius: 16px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        margin: 0;
        animation: slideIn 0.3s ease-out;
        position: relative;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }

    #taskModal h3 {
        color: #333;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 24px;
        margin-top: 0;
        text-align: center;
        letter-spacing: -0.02em;
    }

    /* Modern Form Labels */
    #taskModal label {
        display: block;
        text-align: left;
        margin-bottom: 4px;
        margin-top: 6px;
        font-weight: 500;
        color: #555;
        font-size: 14px;
        letter-spacing: -0.01em;
    }

    #taskModal label:first-of-type {
        margin-top: 0;
    }

    /* Modern Form Inputs */
    .modal-form input, .modal-form select {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        margin-bottom: 4px;
        border: 2px solid #e5e5e5;
        border-radius: 15px;
        font-size: 12px;
        background: white;
        color: #333;
        transition: all 0.2s ease;
        box-sizing: border-box;
        font-family: inherit;
        line-height: 1.4;
        outline: none;
    }

    .modal-form input:focus, .modal-form select:focus {
        border-color: #007AFF;
        box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
    }

    .modal-form input::placeholder {
        color: #999;
        font-size: 13px;
    }

    .modal-form select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23999' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 16px center;
        background-repeat: no-repeat;
        background-size: 16px;
        font-size: 15px;
        padding-right: 48px;
    }

    .modal-form select option {
        font-size: 12px;
        padding: 12px;
    }

    /* Modern Buttons */
    .modal-cancel-button {
        background: #f5f5f5;
        border: none;
        color: #666;
        padding: 0;
        height: 48px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.2s ease;
        flex: 1;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: inherit;
    }

    .modal-cancel-button:hover {
        background: #e5e5e5;
        color: #333;
    }

    .modal-add-button {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0;
        height: 48px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.2s ease;
        flex: 1;
        margin-left: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: inherit;
    }

    .modal-add-button:hover {
        background: #0056CC;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
    }

    .modal-add-button:active {
        transform: translateY(0);
    }

    .modal-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 32px;
        gap: 0;
    }

    h2 {
        color: #31393c !important;
        font-size: 20px !important;
        margin-bottom: 16px !important;
        font-weight: 600 !important;
        position: relative;
        padding-left: 20px;
    }

    h2::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: linear-gradient(135deg, #3e96f4, #5ba4f6);
        border-radius: 2px;
    }

    /* Smooth scrollbar */
    .scroll-area::-webkit-scrollbar {
        width: 8px;
    }

    .scroll-area::-webkit-scrollbar-track {
        background: rgba(204, 199, 191, 0.1);
        border-radius: 4px;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #ccc7bf, #3e96f4);
        border-radius: 4px;
    }

    .scroll-area::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #3e96f4, #5ba4f6);
    }

    /* RESPONSIVE DESIGN - MOBILE OPTIMIZED */
    @media (max-width: 768px) {
        .modal {
            padding: 15px;
        }

        .modal-content {
            max-width: 100%;
            padding: 24px;
            margin: 0 auto;
        }

        .close {
            font-size: 20px;
            right: 16px;
            top: 16px;
            width: 32px;
            height: 32px;
        }

        #taskModal {
            padding: 15px;
        }

        #taskModal > div {
            max-width: 100%;
            padding: 24px;
            margin: 0 auto;
        }

        #taskModal h3 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .modal-form input, .modal-form select {
            height: 44px;
            padding: 0 14px;
            font-size: 16px;
            margin-bottom: 4px;
            border-radius: 20px;
            box-sizing: border-box;
        }

        .modal-cancel-button, .modal-add-button {
            height: 44px;
            font-size: 16px;
            border-radius: 10px;
        }

        .modal-buttons {
            margin-top: 24px;
            gap: 0;
        }

        .modal-cancel-button {
            margin-right: 8px;
        }

        .modal-add-button {
            margin-left: 8px;
        }

        #calendar {
            padding: 15px;
            border-radius: 12px;
            min-height: 500px;
        }

        .scroll-area {
            height: calc(100vh - 120px);
            padding: 15px;
        }

        .fc-header-toolbar {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .fc-toolbar-title {
            font-size: 16px !important;
            order: 0 !important;
            flex: 1 !important;
            text-align: center !important;
            margin: 0 !important;
            min-width: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .fc-toolbar-chunk:first-child {
            order: 0 !important;
            display: flex !important;
            gap: 6px !important;
            flex-shrink: 0 !important;
        }

        .fc-toolbar-chunk:last-child {
            order: 2 !important;
            display: flex !important;
            gap: 6px !important;
            flex-shrink: 0 !important;
        }

        .fc-button {
            font-size: 14px !important;
            padding: 10px 14px !important;
            min-width: 44px !important;
            min-height: 44px !important;
            border-radius: 8px !important;
            touch-action: manipulation !important;
            -webkit-tap-highlight-color: transparent !important;
        }

        .fc-prev-button, .fc-next-button {
            width: 44px !important;
            height: 44px !important;
            padding: 10px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .fc-today-button {
            padding: 10px 12px !important;
            font-size: 13px !important;
            min-height: 44px !important;
            white-space: nowrap !important;
        }

        .fc-col-header-cell {
            padding: 12px 8px !important;
            font-size: 14px !important;
        }

        .fc-daygrid-day-number {
            padding: 8px !important;
            font-size: 14px !important;
            min-height: 36px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .fc-daygrid-day {
            min-height: 50px !important;
        }

        .fc-event {
            padding: 6px 8px !important;
            margin: 2px !important;
            font-size: 12px !important;
            min-height: 24px !important;
            touch-action: manipulation !important;
        }

        .fc-daygrid-day:hover {
            transform: none;
            box-shadow: none;
        }

        .fc-event:hover {
            transform: none !important;
            box-shadow: 0 2px 8px rgba(49, 57, 60, 0.15) !important;
        }

        h2 {
            font-size: 18px !important;
            margin-bottom: 14px !important;
            padding-left: 18px;
        }

        h2::before {
            width: 3px;
            height: 20px;
        }
    }

    @media (max-width: 480px) {
        .modal {
            padding: 10px;
        }

        .modal-content {
            padding: 20px;
            border-radius: 12px;
            max-width: 95%;
            margin: 0 auto;
        }

        .close {
            font-size: 18px;
            right: 12px;
            top: 12px;
            width: 28px;
            height: 28px;
        }

        #taskModal {
            padding: 10px;
        }

        #taskModal > div {
            padding: 20px;
            border-radius: 12px;
            max-width: 95%;
            margin: 0 auto;
        }

        #taskModal h3 {
            font-size: 18px;
            margin-bottom: 18px;
        }

        .modal-form input, .modal-form select {
            height: 42px;
            padding: 0 12px;
            font-size: 16px;
            margin-bottom: 4px;
            border-radius: 15px;
            box-sizing: border-box;
        }

        .modal-cancel-button, .modal-add-button {
            height: 42px;
            font-size: 15px;
            border-radius: 8px;
        }

        .modal-buttons {
            margin-top: 20px;
            gap: 0;
        }

        .modal-cancel-button {
            margin-right: 6px;
        }

        .modal-add-button {
            margin-left: 6px;
        }

        .scroll-area {
            padding: 10px;
        }

        #calendar {
            padding: 10px;
            border-radius: 10px;
        }

        .fc-header-toolbar {
            padding: 10px 12px;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            gap: 6px !important;
        }

        .fc-toolbar-title {
            font-size: 14px !important;
            order: 0 !important;
            flex: 1 !important;
            text-align: center !important;
            margin: 0 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-width: 0 !important;
        }

        .fc-toolbar-chunk:first-child {
            order: 0 !important;
            display: flex !important;
            gap: 4px !important;
            flex-shrink: 0 !important;
        }

        .fc-toolbar-chunk:last-child {
            order: 2 !important;
            display: flex !important;
            gap: 4px !important;
            flex-shrink: 0 !important;
        }

        .fc-button {
            font-size: 12px !important;
            padding: 8px 12px !important;
            min-width: 40px !important;
            min-height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 6px !important;
            touch-action: manipulation !important;
            -webkit-tap-highlight-color: transparent !important;
        }

        .fc-prev-button, .fc-next-button {
            width: 40px !important;
            height: 40px !important;
            padding: 8px !important;
        }

        .fc-today-button {
            padding: 8px 10px !important;
            font-size: 11px !important;
            min-height: 40px !important;
            white-space: nowrap !important;
        }

        .fc-col-header-cell {
            padding: 8px 4px !important;
            font-size: 12px !important;
        }

        .fc-daygrid-day-number {
            padding: 6px !important;
            font-size: 13px !important;
            min-height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .fc-daygrid-day {
            min-height: 45px !important;
        }

        .fc-event {
            padding: 4px 6px !important;
            font-size: 11px !important;
            border-radius: 4px !important;
            min-height: 20px !important;
            margin: 1px !important;
            touch-action: manipulation !important;
        }

        h2 {
            font-size: 16px !important;
            margin-bottom: 12px !important;
            padding-left: 16px;
        }

        h2::before {
            width: 3px;
            height: 18px;
        }

        .scroll-area::-webkit-scrollbar {
            width: 4px;
        }
    }

    @media (max-width: 360px) {
        .modal {
            padding: 8px;
        }

        .modal-content {
            padding: 16px;
            border-radius: 10px;
            max-width: 95%;
            margin: 0 auto;
        }

        .close {
            font-size: 16px;
            right: 10px;
            top: 10px;
            width: 24px;
            height: 24px;
        }

        #taskModal {
            padding: 8px;
        }

        #taskModal > div {
            padding: 16px;
            border-radius: 10px;
            max-width: 95%;
            margin: 0 auto;
        }

        #taskModal h3 {
            font-size: 20px;
            margin-bottom: 16px;
        }

        .modal-form input, .modal-form select {
            height: 40px;
            padding: 0 12px;
            font-size: 15px;
            margin-bottom: 4px;
            border-radius: 15px;
            box-sizing: border-box;
        }

        .modal-cancel-button, .modal-add-button {
            height: 40px;
            font-size: 14px;
            border-radius: 6px;
        }
        .modal-buttons {
            gap: 6px;
            margin-top: 10px;
        }

        .fc-header-toolbar {
            padding: 8px 10px;
        }

        .fc-toolbar-title {
            font-size: 12px !important;
        }

        .fc-button {
            font-size: 11px !important;
            padding: 6px 10px !important;
            min-width: 36px !important;
            min-height: 36px !important;
        }

        .fc-prev-button, .fc-next-button {
            width: 36px !important;
            height: 36px !important;
            padding: 6px !important;
        }

        .fc-today-button {
            padding: 6px 8px !important;
            font-size: 10px !important;
            min-height: 36px !important;
        }

        .fc-col-header-cell {
            padding: 6px 2px !important;
            font-size: 11px !important;
        }

        .fc-daygrid-day-number {
            padding: 4px !important;
            font-size: 12px !important;
            min-height: 28px !important;
        }

        .fc-daygrid-day {
            min-height: 40px !important;
        }

        .fc-event {
            padding: 3px 4px !important;
            font-size: 10px !important;
            min-height: 18px !important;
        }

        h2 {
            font-size: 14px !important;
            margin-bottom: 10px !important;
            padding-left: 14px;
        }

        h2::before {
            width: 2px;
            height: 16px;
        }
    }
</style>

<div class="scroll-area">
    <h2>Activity Calendar</h2>
    <div id="calendar"></div>
</div>

<!-- Event Detail Modal -->
<div id="eventModal" class="modal" style="display: none;">
    <div class="modal-content" style="font-size: 14px;">
        <span class="close" onclick="closeModalCustom()">&times;</span>
        <h3 id="modalTitle"></h3>
        <p><strong>Description:</strong> <span id="modalDescription"></span></p>
        <p><strong>Deadline:</strong> <span id="modalDate"></span></p>
    </div>
</div>

<!-- Add Task Modal -->
<center>
    <div id="taskModal">
        <div>
            <h3>Add New Task</h3>
            <form action="/tasks" method="POST" class="modal-form">
                @csrf
                <input type="hidden" name="column_id" id="modalColumnId" value="1">

                <label for="title">Task Title</label>
                <input type="text" name="title" id="title" placeholder="Enter task title" required>
                
                <label for="description">Description</label>
                <input type="text" name="description" id="description" placeholder="Enter description">

                <label for="modalDeadline">Deadline</label> <!-- Tambahkan label ini -->
                <input type="date" name="deadline" id="modalDeadline">
                <select name="priority_color">
                    <option value="">Priority Color</option>
                    <option value="red">Red</option>
                    <option value="yellow">Yellow</option>
                    <option value="green">Green</option>
                </select>

                <div style="display: flex; justify-content: space-between; margin-top: 16px;">
                    <button type="button" onclick="closeModal()" class="modal-cancel-button">Cancel</button>
                    <button type="submit" class="modal-add-button">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</center>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/calendar/events',
            eventTimeFormat: false,
            editable: true,
            selectable: true,

            longPressDelay: 500, // Waktu penekanan jari sebelum drag dimulai (dalam ms)
            eventLongPressDelay: 500, 

            dateClick: function (info) {
                document.getElementById('modalDeadline').value = info.dateStr;
                document.getElementById('taskModal').style.display = 'flex';
            },

            eventClick: function (info) {
                document.getElementById("modalDate").textContent = info.event.startStr;
                document.getElementById("modalDescription").textContent = info.event.extendedProps.description;
                document.getElementById("modalTitle").textContent = info.event.title;
                document.getElementById('eventModal').style.display = 'block';
                info.jsEvent.preventDefault();
            },

            eventDrop: function (info) {
                const id = info.event.id;
                const dateChange = info.event.startStr;

                fetch(`/tasks/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        _method: "PUT",
                        deadline: dateChange
                    })
                }).then(response => {
                    if (!response.ok) {
                        alert("Terjadi kesalahan di sisi server");
                        info.revert();
                    }
                });
            }
        });
        calendar.render();
    });

    function closeModalCustom() {
        document.getElementById('eventModal').style.display = 'none';
    }

    function closeModal() {
        document.getElementById('taskModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const eventModal = document.getElementById('eventModal');
        const taskModal = document.getElementById('taskModal');
        
        if (event.target === eventModal) {
            closeModalCustom();
        }
        if (event.target === taskModal) {
            closeModal();
        }
    }
</script>
@endsection