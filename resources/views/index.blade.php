@extends('layouts.app')
@section('browser-title', 'Все задачи')
@section('content')
    <div class="p-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h1 class="mb-3">Задачи</h1>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Новая задача</a>
            </div>
            <form method="GET" class="border p-3 border-primary rounded" style="max-width: 50%;">
                <div class="d-flex justify-content-start mb-3">
                    <div>
                        <label class="mb-1" for="date-select">Крайний срок:</label>
                        <select name="date"
                                class="form-select form-select-sm border-primary"
                                id="date-select"
                                aria-label=".form-select-sm">
                            <option
                                value="{{ today()->toDateString() }}"
                            >
                                Сегодня
                            </option>
                            <option
                                value="{{ today()->addWeek()->toDateString() }}"
                            >
                                Неделя
                            </option>
                            <option
                                value="{{ today()->addMonth()->toDateString() }}"
                            >
                                Месяц
                            </option>
                        </select>
                    </div>
                    @if($users && $users->count())
                        <div>
                            <label class="mb-1" for="peron-select">Ответственный:</label>
                            <select name="person"
                                    class="form-select form-select-sm border-primary"
                                    id="peron-select"
                                    aria-label=".form-select-sm"
                            >
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                                    @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                <input type="submit" class="btn btn-outline-primary" value="Отфильтровать">
            </form>
        </div>
        @if($filters && $filters->count())
            <div class="border border-danger rounded p-3 mb-3">
                <h3>Действуют фильтры:</h3>
                @if($filters->get('date'))
                    <p class="m-0">Крайний срок: <strong>{{ $filters->get('date') }}</strong></p>
                @endif
                @if($filters->get('person'))
                    <p>Исполнитель: <strong>{{ $filters->get('person') }}</strong></p>
                @endif
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Сбросить фильтры</a>
            </div>
        @endif
        <div>
            @if($tasks && $tasks->count())
                @foreach($tasks as $task)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                @if($task->creator == auth()->user()->id)
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-outline-warning mt-2 mb-2">
                                        Отредактировать задачу
                                    </a>
                                @endif
                                @if($task->creator == auth()->user()->supervisor && $task->responsible_person == auth()->user()->id)
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-outline-warning mt-2 mb-2">
                                        Изменить статус
                                    </a>
                                @endif
                                <h4>{{ $task->title }}</h4>
                                <p class="m-0">Ответственный:
                                    <span class="text-muted">
                                        {{ $task->user_surname }} {{ $task->user_name }} {{ $task->user_patronymic }}
                                    </span>
                                </p>
                            </div>
                            <p class="m-0">Статус: {{ $task->status }}</p>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $task->description }}</p>
                            <div class="d-flex justify-content-between">
                                <p class="m-0 text-muted">Дата окончания: {{ $task->expiration_date }}</p>
                                <p class="m-0 text-muted">Приоритет: {{ $task->execution }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Заданий нет</h2>
            @endif
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>Заголовок задачи</h4>
                        <p class="m-0">Ответственный: <span class="text-muted">Евгений</span></p>
                    </div>
                    <p class="m-0">Статус: к выполнению</p>
                </div>
                <div class="card-body">
                    <p class="card-text">Текст задачи текст задачи  текст задачи  текст задачи  текст задачи  текст задачи </p>
                    <div class="d-flex justify-content-between">
                        <p class="m-0 text-muted">Дата окончания: 21.02.20</p>
                        <p class="m-0 text-muted">Приоритет: высокий</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
