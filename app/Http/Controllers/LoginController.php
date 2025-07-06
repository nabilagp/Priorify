<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect()->route('board');
        }
        return view('login');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'password' => bcrypt(Str::random(16)),
        ]);

        Auth::login($user);
        return redirect('/board');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function authenticate(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/board');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

}
