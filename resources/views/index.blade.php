@extends('layouts.app')
@section('browser-title', 'Все задачи')
@section('content')
    <div class="p-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h1 class="mb-3">Задачи</h1>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">Новая задача</a>
            </div>
            <div class="d-flex justify-content-end">
                @if($subordinates && $subordinates->count())
                    <form method="GET" class="border p-3 border-primary rounded me-2">
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <label class="mb-1" for="person-select">Мои подчиненные:</label>
                                <select name="person" class="form-select form-select-sm border-primary" id="person-select"
                                        aria-label=".form-select-sm">
                                    @foreach($subordinates as $subordinate)
                                        <option value="{{ $subordinate->id }}"
                                            {{ request()->get('person') == $subordinate->id ? 'selected' : '' }}>
                                            {{ $subordinate->surname }} {{ $subordinate->name }} {{ $subordinate->patronymic }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <input type="submit" class="btn btn-outline-primary" value="Отфильтровать">
                            @if(request()->get('person'))
                                <a href="{{ route('tasks.index') }}" class="btn btn-danger mt-2">Сбросить фильтр</a>
                            @endif
                        </div>
                    </form>
                @endif
                <form method="GET" class="border p-3 border-primary rounded">
                    <div class="d-flex mb-2">
                        <div class="flex-grow-1">
                            <label class="mb-1" for="date-select">Мои задачи на:</label>
                            <select name="date" class="form-select form-select-sm border-primary" id="date-select"
                                    aria-label=".form-select-sm">
                                <option value="today" {{ request()->get('date') == 'today' ? 'selected' : '' }}>Сегодня</option>
                                <option value="week" {{ request()->get('date') == 'week' ? 'selected' : '' }}>Неделю</option>
                                <option value="more" {{ request()->get('date') == 'more' ? 'selected' : '' }}>Больше чем неделю</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <input type="submit" class="btn btn-outline-primary" value="Отфильтровать">
                        @if(request()->get('date'))
                            <a href="{{ route('tasks.index') }}" class="btn btn-danger mt-2">Сбросить фильтр</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
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
                                @elseif($task->creator == auth()->user()->supervisor && $task->responsible_person == auth()->user()->id)
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-outline-warning mt-2 mb-2">
                                        Изменить статус
                                    </a>
                                @endif
                                <h4 class="
                                    @if($task->status == 'completed')
                                        text-success
                                    @elseif(strtotime($task->expiration_date) < strtotime(date('Y-m-d')))
                                        text-danger
                                    @endif
                                ">{{ $task->title }}</h4>
                                <p class="m-0">Ответственный:
                                    <span class="text-muted">
                                        <strong>
                                        {{ $task->user_surname }} {{ $task->user_name }} {{ $task->user_patronymic }}
                                        </strong>
                                    </span>
                                </p>
                            </div>
                            <p class="m-0">Статус: {{ getHtmlForStatus($task->status) }}</p>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $task->description }}</p>
                            <div class="d-flex justify-content-between">
                                <p class="m-0 text-muted">Дата окончания: {{ $task->expiration_date }}</p>
                                <p class="m-0 text-muted">Приоритет: {{ getHtmlForExecution($task->execution) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h2>Задач нет</h2>
            @endif
        </div>
    </div>
@endsection
