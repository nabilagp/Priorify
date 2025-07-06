<?php

use App\Mail\NotificationEmail;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function(){
    $tomorrow = Carbon::tomorrow();

    // Example: tasks due today or overdue
    $tasks = Task::with('user')->whereDate('deadline', $tomorrow)->get();

    foreach ($tasks as $task) {
        Mail::to($task->user->email)->send(new NotificationEmail($task->title, $task->description, $task->deadline));
    }
})->daily();
