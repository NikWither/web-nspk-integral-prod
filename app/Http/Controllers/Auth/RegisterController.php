<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
        ]);

        $baseSlug = Str::slug($validated['name']);

        if ($baseSlug === '') {
            $baseSlug = 'user';
        }

        $email = $baseSlug.'@demo.local';
        $suffix = 1;

        while (User::where('email', $email)->exists()) {
            $email = $baseSlug.$suffix.'@demo.local';
            $suffix++;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $email,
            'password' => Str::random(40),
            'type_account' => 'business',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Demo registration complete!');
    }
}
