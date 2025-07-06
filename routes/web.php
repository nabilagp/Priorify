<?php

// ... route yang sudah ada tetap
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



// Tambahkan jika belum ada
Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');


Route::get('/', function () {
    if(Auth::user()){
        return redirect()->route('board');
    }
    return redirect()->route('login');
});



Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful',
            'redirect_url' => route('board')
        ]);
    }

    return response()->json([
        'message' => 'Invalid credentials'
    ], 401);
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('auth/google', [LoginController::class, 'redirectToProvider'])->name('google.login');  
Route::get('auth/google/callback', [LoginController::class, 'handleProviderCallback'])->name('login.google.callback');

Route::get('/latest-task', [ProfileController::class, 'getLatestTask'])->name('latest-task');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/board', [BoardController::class, 'index'])->name('board');

    Route::post('/tasks', [BoardController::class, 'store']);
    Route::post('/update-tasks', [BoardController::class, 'updateTasks']);
    Route::delete('/tasks/{task}', [BoardController::class, 'destroy']);
    

    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/calendar/tasks', [TaskController::class, 'calendarTasks']);
    Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');

    Route::get('/calendar/events', [CalendarController::class, 'events']);
    Route::get('/list', [ListController::class, 'index'])->name('list');
    Route::get('/report', [ReportController::class, 'index'])->name('report');
});
