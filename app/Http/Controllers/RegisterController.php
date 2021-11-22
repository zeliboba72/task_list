<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('register.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "login"      => "required|min:3|max:255",
            "name"       => "required|max:255",
            "surname"    => "required|max:255",
            "patronymic" => "required|max:255",
            "password"   => "required|min:6|max:255",
            "supervisor" => "",
        ]);

        $data["password"] = bcrypt($data["password"]);

        $user = User::create($data);

        auth()->login($user);

        return redirect()->route('tasks.index');
    }
}
