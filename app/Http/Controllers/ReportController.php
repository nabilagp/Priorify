<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // Tambahkan baris ini!

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $groupBy = $request->get('group_by', 'date');

        $tasks = Task::where('user_id', auth()->id()) // 👈 Tambahkan ini
        ->selectRaw("
            COUNT(*) as total,
            " . match($groupBy) {
                'date' => "DATE(deadline) as label",
                'week' => "WEEK(deadline, 1) as label",
                'month' => "MONTHNAME(deadline) as label",
                default => "DATE(deadline) as label"
            }
        )
        ->groupBy('label')
        ->orderByRaw('MIN(deadline)')
        ->get();

        return view('report', compact('tasks', 'groupBy'));
    }
}

