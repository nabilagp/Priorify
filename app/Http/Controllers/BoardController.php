<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BoardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
    return redirect()->route('login');
}
        $userId = Auth::user()->id;

        // Ambil kolom beserta tugas milik user
        $columns = Column::with(['tasks' => function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where(function ($q) {
                    $q->whereHas('column', function ($col) {
                        $col->where('name', '!=', 'Completed');
                    })
                    ->orWhere(function ($q2) {
                        $q2->whereHas('column', function ($col2) {
                            $col2->where('name', 'Completed');
                        })->where('updated_at', '>=', Carbon::now()->subDays(7));
                    });
                });
        }])->get();

        // Buat data untuk kalender (tidak digunakan di view board saat ini)
        $tasks = Task::where('user_id', $userId)->groupBy('deadline');

        // Warna pastel (jika nanti mau dikirim ke view, bisa ditambahkan juga)
        $pastelColors = [
            'red' => '#ff9999',
            'blue' => '#add8e6',
            'green' => '#b3ffb3',
            'yellow' => '#ffffcc',
            'purple' => '#e0bbff',
        ];

        // Hitung jumlah tugas per status
        $statusCounts = [
            'To Do' => 0,
            'In Progress' => 0,
            'Completed' => 0,
        ];

        foreach ($columns as $column) {
            if (isset($statusCounts[$column->name])) {
                $statusCounts[$column->name] = $column->tasks->count();
            }
        }

        // Kirim data ke view
        return view('board', compact('columns', 'tasks', 'statusCounts'));
    }

   public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'deadline' => 'required|date',
        'priority_color' => 'nullable|string',
        'column_id' => 'required|exists:columns,id',
    ]);

    Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'deadline' => $request->deadline,
        'priority_color' => $request->priority_color,
        'column_id' => $request->column_id,
        'order' => Task::where('column_id', $request->column_id)->max('order') + 1,
        'user_id' => Auth::user()->id,
    ]);

    return redirect()->back()->with('success', 'Task berhasil ditambahkan!');
}


    public function updateTasks(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->column_id = $request->column_id;
        $task->save();

        return response()->json([
            'success' => true,
            'task_id' => $task->id,
            'new_column_id' => $task->column_id
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}
