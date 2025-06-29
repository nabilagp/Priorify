<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function show()
    {
        return view('calendar');
    }

    public function events()
    {
        $pastelColors = [
            'red' => '#ff9999',
            'blue' => '#add8e6',
            'green' => '#b3ffb3',
            'yellow' => '#ffffcc',
            'purple' => '#e0bbff',
        ];
        $tasks = Task::where('user_id', Auth::user()->id)->whereNotNull('deadline')->get();

        $events = $tasks->map(function ($task) use ($pastelColors) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'start' => $task->deadline->format('Y-m-d'),
                'description' => $task->description,
                // 'url'   => route('tasks.show', $task->id), // opsional jika ada halaman detail
                'color'       => $pastelColors[$task->priority_color] ?? '#3788d8',
                'textColor'   => '#000000',
            ];
        });

        return response()->json($events);
    }

}
