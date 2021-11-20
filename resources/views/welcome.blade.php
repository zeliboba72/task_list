@extends('layouts.app')
@section('browser-title', 'Главная')
@section('content')
    <div class="p-4">
        <div class="d-flex justify-content-between mb-3">
            <h1 class="mb-3">Задачи</h1>
            <form method="GET" class="border p-3 border-primary rounded" style="max-width: 50%;">
                <div class="d-flex justify-content-start mb-3">
                    <select class="form-select form-select-sm me-3 border-primary" aria-label=".form-select-sm">
                        <option selected>Дата окончания</option>
                        <option value="1">Сегодня</option>
                        <option value="2">Ближайшая неделя</option>
                        <option value="3">Больше, чем неделя</option>
                    </select>
                    <select class="form-select form-select-sm border-primary" aria-label=".form-select-sm">
                        <option selected>Ответственный</option>
                        <option value="1">Евгений</option>
                        <option value="2">Михаил</option>
                        <option value="3">Надежда</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-outline-primary" value="Отфильтровать">
            </form>
        </div>
        <div>
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
