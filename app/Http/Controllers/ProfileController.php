<?php
// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getLatestTask()
{
    $user = Auth::user();
    $lastTask = $user->tasks()->latest()->first();

    return response()->json([
        'title' => $lastTask?->title ?? 'No tasks yet',
        'created_at' => $lastTask?->created_at->format('d M Y') ?? '-',
    ]);
}

}
