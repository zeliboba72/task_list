@extends('layouts.app')
@section('browser-title', 'Редактирование задачи')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-xl-5">
            <h1 class="mt-4 mb-4">Редактирование задачи</h1>
            <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="border rounded p-4">
                @method('PATCH')
                @csrf
                <h2>{{ $task->title }}</h2>
                <p>{{ $task->description }}</p>
                <div class="mb-3">
                    <label for="input-status" class="form-label">Статус задачи:</label>
                    <select name="status" class="form-select" id="input-status">
                        <option value="established" {{ $task->status == "established" ? "selected" : "" }}>
                            К выполнению
                        </option>
                        <option value="performed" {{ $task->status == "performed" ? "selected" : "" }}>
                            Выполняется
                        </option>
                        <option value="completed" {{ $task->status == "completed" ? "selected" : "" }}>
                            Выполнена
                        </option>
                        <option value="canceled" {{ $task->status == "canceled" ? "selected" : "" }}>
                            Отменена
                        </option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Изменить">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Отмена</a>
            </form>
        </div>
    </div>
@endsection
