<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index()
    {
        $priorityOrder = ['#ff9999', '#ffffcc', '#add8e6', '#e0bbff', '#b3ffb3'];

        $tasks = Task::with('column')
            ->where('user_id', auth()->id())
            ->orderByRaw("FIELD(priority_color, ?, ?, ?, ?, ?)", $priorityOrder)
            ->orderBy('deadline')
            ->get();

        return view('list', compact('tasks'));
    }
}
