@extends('layout.app')
@section('title', 'Priorify - Report')

@section('content')

<style>
    .fixed-header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
        border-bottom: 1px solid rgba(204, 199, 191, 0.3);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 16px rgba(49, 57, 60, 0.08);
    }

    .fixed-menu {
        position: fixed;
        top: 60px; /* sesuaikan dengan tinggi header */
        width: 100%;
        z-index: 999;
        background: linear-gradient(135deg, #edeeeb 0%, #ccc7bf 100%);
        border-bottom: 1px solid rgba(204, 199, 191, 0.4);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 12px rgba(49, 57, 60, 0.06);
    }
    .fixed-header, .fixed-menu {
    margin: 0;
    padding: 0;
}

    .scrollable-content {
        margin-top: 0;
        height: calc(100vh - 120px);
        overflow-y: auto;
        padding: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #edeeeb 100%);
    }

    .scrollable-content::-webkit-scrollbar {
        width: 8px;
    }

    .scrollable-content::-webkit-scrollbar-track {
        background: #edeeeb;
        border-radius: 4px;
    }

    .scrollable-content::-webkit-scrollbar-thumb {
        background: #ccc7bf;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .scrollable-content::-webkit-scrollbar-thumb:hover {
        background: #31393c;
    }

    .report-container {
        font-size: 14px;
        margin: 0 auto;
        max-width: 1000px;
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

    .report-container h2 {
        font-size: 24px;
        text-align: center;
        color: #31393c;
        font-weight: 600;
        margin-bottom: 30px;
        letter-spacing: -0.02em;
    }

    .report-form {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-bottom: 35px;
        gap: 20px;
        background: linear-gradient(135deg, #ffffff 0%, rgba(237, 238, 235, 0.8) 100%);
        padding: 20px 24px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(49, 57, 60, 0.1);
        border: 1px solid rgba(204, 199, 191, 0.3);
        backdrop-filter: blur(10px);
    }

    .report-form label {
        font-weight: 600;
        font-size: 14px;
        color: #31393c;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        font-size: 12px;
        margin-bottom: 0;
    }

    .report-form select {
        padding: 12px 16px;
        border-radius: 10px;
        border: 2px solid #ccc7bf;
        font-size: 14px;
        background: #ffffff;
        color: #31393c;
        transition: all 0.3s ease;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2331393c' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
        min-width: 120px;
    }

    .report-form select:focus {
        border-color: #3e96f4;
        outline: none;
        box-shadow: 0 0 0 3px rgba(62, 150, 244, 0.1);
        transform: translateY(-1px);
    }

    .report-form select:hover {
        border-color: #31393c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(49, 57, 60, 0.1);
    }

    .chart-wrapper {
        position: relative;
        width: 100%;
        max-width: 900px;
        height: 450px;
        background: linear-gradient(135deg, #ffffff 0%, rgba(237, 238, 235, 0.3) 100%);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 12px 40px rgba(49, 57, 60, 0.12);
        margin: 0 auto;
        border: 1px solid rgba(204, 199, 191, 0.2);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .chart-wrapper:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(49, 57, 60, 0.15);
    }

    /* Form group styling */
    .form-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .report-form > * {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    /* Responsive improvements */
    @media (max-width: 600px) {
        .report-form {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
        }

        .report-form > * {
            flex-direction: column;
            align-items: stretch;
        }

        .report-form label {
            margin-bottom: 8px;
            text-align: left;
        }

        .report-form select {
            min-width: unset;
            width: 100%;
        }

        .chart-wrapper {
            padding: 16px;
            height: 350px;
        }

        .scrollable-content {
            padding: 16px;
        }
    }

    /* Loading state for chart */
    .chart-wrapper canvas {
        transition: opacity 0.3s ease;
    }

    .chart-wrapper.loading canvas {
        opacity: 0.6;
    }

    /* Enhanced focus states for accessibility */
    .report-form select:focus-visible {
        outline: 2px solid #3e96f4;
        outline-offset: 2px;
    }
</style>

<div>
    @include('partials.header')
    @include('partials.menu')
</div>

<div class="scrollable-content">
    <div class="report-container">
        <h2>Task Report</h2>

        <form method="GET" action="{{ route('report') }}" class="report-form">
            <div class="form-group">
                <label for="group_by">Group by:</label>
                <select name="group_by" id="group_by" onchange="this.form.submit()">
                    <option value="date" {{ $groupBy == 'date' ? 'selected' : '' }}>Tanggal</option>
                    <option value="week" {{ $groupBy == 'week' ? 'selected' : '' }}>Minggu</option>
                    <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Bulan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="chart_type">Chart type:</label>
                <select id="chart_type" onchange="changeChartType(this.value)">
                    <option value="line">Line</option>
                    <option value="bar">Bar</option>
                    <option value="pie">Pie</option>
                    <option value="doughnut">Doughnut</option>
                </select>
            </div>
        </form>

        <div class="chart-wrapper">
            <canvas id="taskChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentChartType = 'line';
    const ctx = document.getElementById('taskChart').getContext('2d');

    // Updated colors to match the color palette
    const chartData = {
        labels: {!! json_encode($tasks->pluck('label')) !!},
        datasets: [{
            label: 'Jumlah Tugas',
            data: {!! json_encode($tasks->pluck('total')) !!},
            backgroundColor: [
                '#3e96f4', '#31393c', '#ccc7bf', '#edeeeb',
                'rgba(62, 150, 244, 0.8)', 'rgba(49, 57, 60, 0.8)', 
                'rgba(204, 199, 191, 0.8)', 'rgba(237, 238, 235, 0.8)'
            ],
            borderColor: '#31393c',
            borderWidth: 2,
            fill: false,
            tension: 0.4,
            pointBackgroundColor: '#3e96f4',
            pointBorderColor: '#31393c',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    };

    let chart = new Chart(ctx, {
        type: currentChartType,
        data: chartData,
        options: getChartOptions(currentChartType)
    });

    function changeChartType(newType) {
        // Add loading state
        document.querySelector('.chart-wrapper').classList.add('loading');
        
        setTimeout(() => {
            chart.destroy();
            currentChartType = newType;
            chart = new Chart(ctx, {
                type: currentChartType,
                data: chartData,
                options: getChartOptions(currentChartType)
            });
            
            // Remove loading state
            document.querySelector('.chart-wrapper').classList.remove('loading');
        }, 150);
    }

    function getChartOptions(type) {
        const isCircular = (type === 'pie' || type === 'doughnut');
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#31393c',
                        font: {
                            family: 'Inter',
                            size: 12,
                            weight: '500'
                        }
                    }
                }
            },
            scales: isCircular ? {} : {
                x: {
                    ticks: {
                        color: '#31393c',
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(204, 199, 191, 0.3)'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#31393c',
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(204, 199, 191, 0.3)'
                    }
                }
            }
        };
    }
</script>
@endsection