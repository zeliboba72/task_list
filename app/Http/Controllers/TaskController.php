<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filled('date')) {
            $tasks = Task::filterDate($request->get('date'))
                ->orderBy('updated_at', 'desc');
        } elseif ($request->filled('person')) {
            $tasks = Task::filterByUser($request->get('person'))
                ->orderBy('updated_at', 'desc');
        } else {
            $tasks = Task::orderBy('updated_at', 'desc');
        }

        $tasks = $tasks->join('users', 'tasks.responsible_person', '=', 'users.id')
              ->select('tasks.*',
                    'users.name as user_name',
                    'users.surname as user_surname',
                    'users.patronymic as user_patronymic')
              ->orderBy('updated_at', 'asc')
              ->get();
        $subordinates = User::subordinates(auth()->user()->id)->get();
        return view('index', compact('tasks', 'subordinates'));
    }

    public function create()
    {
        $subordinates = User::subordinates(auth()->user()->id)->get();
        return view('create', compact('subordinates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title"              => "required|min:6|max:255",
            "description"        => "required|min:6|max:999",
            "execution"          => "required|",
            "expiration_date"    => "required|date",
            "responsible_person" => "required",
            "creator"            => "required",
        ]);

        $task = new Task();
        $task->fill($data);
        $task->save();

        return redirect()->route('tasks.index');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        // Проверяем, является ли пользователем создателем или исполнителем задачи
        if ($task->creator != auth()->user()->id && $task->responsible_person != auth()->user()->id) {
            return redirect()->route('tasks.index');
        }

        // Проверяем, если задача создана не самим пользователем, а его руководителем
        if ($task->creator == auth()->user()->supervisor) {
            return view('edit-only-status', compact('task'));
        }

        $users = User::where('supervisor', '=', auth()->user()->id)->get();
        return view('edit', compact('users', 'task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Проверяем, является ли пользователем создателем или исполнителем задачи
        if ($task->creator != auth()->user()->id && $task->responsible_person != auth()->user()->id) {
            return redirect()->route('tasks.index');
        }

        if ($task->creator == auth()->user()->supervisor) {
            $data = $request->validate([
                "status" => "required",
            ]);
        } else {
            $data = $request->validate([
                "title"              => "required|min:6|max:255",
                "description"        => "required|min:6|max:999",
                "execution"          => "required",
                "expiration_date"    => "required|date",
                "responsible_person" => "required",
                "status"             => "required",
            ]);
        }

        $task->fill($data);
        $task->save();
        return redirect()->route('tasks.index');
    }
}
