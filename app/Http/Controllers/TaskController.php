<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
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
}
