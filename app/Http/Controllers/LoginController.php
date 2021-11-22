<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $data  = $request->validate([
            "login"    => "required|max:255",
            "password" => "required|max:255",
        ]);

        if (auth()->attempt($data)) {
            $request->session()->regenerate();
            return redirect()->intended(route('tasks.index'));
        }

        throw ValidationException::withMessages([
            "password" => "Введенные данные не подходят",
        ]);
    }

    public function destroy(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
