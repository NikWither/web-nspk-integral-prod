<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $user = User::where('name', $validated['name'])->first();

        if (! $user) {
            return back()->withErrors([
                'name' => 'User not found.',
            ])->onlyInput('name');
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('status', 'Welcome back!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'See you soon!');
    }
}
