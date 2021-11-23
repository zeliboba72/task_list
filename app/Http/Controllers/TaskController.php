<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $users = getSubordinatesForCurrentUser();
        $filters = collect();

        if ($request->get('date')) {
            if (checkDateFormat($request->get('date'))) {
                $tasksQuery = Task::whereDate('expiration_date', '<=', $request->get('date'));
                $filters->put("date", $request->get('date'));
            }
        }

        if ($request->get('person') && is_numeric($request->get('person'))) {
            if (isset($tasksQuery)) {
                $tasksQuery->where('responsible_person', '=', $request->get('person'));
            } else {
                $tasksQuery = Task::where('responsible_person', '=', $request->get('person'));
            }
            $filterUser = $users->firstWhere("id", $request->get('person'));
            if ($filterUser) {
                $filters->put('person', $filterUser->surname . " " . $filterUser->name . " " . $filterUser->patronymic);
            }
        }

        if (isset($tasksQuery)) {
            $tasksQuery->orderBy('updated_at', 'asc')
                ->join('users', 'tasks.responsible_person', '=', 'users.id')
                ->select('tasks.*',
                    'users.name as user_name',
                    'users.surname as user_surname',
                    'users.patronymic as user_patronymic');
        } else {
            $tasksQuery = Task::orderBy('updated_at', 'asc')
                ->join('users', 'tasks.responsible_person', '=', 'users.id')
                ->select('tasks.*',
                    'users.name as user_name',
                    'users.surname as user_surname',
                    'users.patronymic as user_patronymic');
        }

        $tasks = $tasksQuery->get();

        return view('index', compact('tasks', 'users', 'filters'));
    }

    public function create()
    {
        $users = User::where('supervisor', '=', auth()->user()->id)->get();
        return view('create', compact('users'));
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
