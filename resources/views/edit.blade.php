@extends('layouts.app')
@section('browser-title', 'Редактирование задачи')
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="mt-4 mb-4">Редактирование задачи</h1>
            <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="border rounded p-4">
                @method('PATCH')
                @csrf
                <div class="mb-3">
                    <label for="input-title" class="form-label">Заголовок:</label>
                    <input name="title"
                           type="text"
                           class="form-control"
                           id="input-title"
                           value="{{ old('title') ?: $task->title }}" required>
                    @error('title')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-description" class="form-label">Описание:</label>
                    <textarea name="description"
                              class="form-control"
                              id="input-description"
                              required>{{ old('description') ?: $task->description }}
                    </textarea>
                    @error('description')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-execution" class="form-label">Приоритет:</label>
                    <select name="execution"
                            class="form-select"
                            id="input-execution"
                            aria-label="execution-select"
                            required
                    >
                        @if(old('execution'))
                            <option value="low"  {{ old('execution') === "low" ? 'selected' : '' }}>Низкий</option>
                            <option value="medium" {{ old('execution') === "medium" ? 'selected' : '' }}>Средний</option>
                            <option value="high" {{ old('execution') === "high" ? 'selected' : '' }}>Высокий</option>
                        @else
                            <option value="low"  {{ $task->execution === "low" ? 'selected' : '' }}>Низкий</option>
                            <option value="medium" {{ $task->execution === "medium" ? 'selected' : '' }}>Средний</option>
                            <option value="high" {{ $task->execution === "high" ? 'selected' : '' }}>Высокий</option>
                        @endif

                    </select>
                </div>
                <div class="mb-3">
                    <label for="input-responsible-person" class="form-label">Ответственный:</label>
                    <select name="responsible_person"
                            class="form-select"
                            id="input-responsible-person"
                            aria-label="responsible-person-select"
                            required
                    >
                        <option value="{{ auth()->user()->id }}">Назначить меня</option>
                        @if($users && $users->count())
                            @if(old('responsible_person'))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('responsible_person') == $user->id ? 'selected' : '' }}>
                                        {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}
                                    </option>
                                @endforeach
                            @else
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $task->responsible_person == $user->id ? 'selected' : '' }}>
                                        {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}
                                    </option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="input-date" class="form-label">Крайний срок:</label>
                    @if(old('expiration_date'))
                        <input name="expiration_date" type="date" class="form-control" id="input-date" value="{{ old('expiration_date') }}" required>
                    @else
                        <input name="expiration_date" type="date" class="form-control" id="input-date" value="{{ $task->expiration_date }}" required>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="input-status" class="form-label">Статус задачи:</label>
                    <select name="status" class="form-select" id="input-status">
                        @if(old("status"))
                            <option value="established" {{ old("status") == "established" ? "selected" : "" }}>К выполнению</option>
                            <option value="performed" {{ old("status") == "performed" ? "selected" : "" }}>Выполняется</option>
                            <option value="completed" {{ old("status") == "completed" ? "selected" : "" }}>Выполнена</option>
                            <option value="canceled" {{ old("status") == "canceled" ? "selected" : "" }}>Отменена</option>
                        @else
                            <option value="established" {{ $task->status == "established" ? "selected" : "" }}>К выполнению</option>
                            <option value="performed" {{ $task->status == "performed" ? "selected" : "" }}>Выполняется</option>
                            <option value="completed" {{ $task->status == "completed" ? "selected" : "" }}>Выполнена</option>
                            <option value="canceled" {{ $task->status == "canceled" ? "selected" : "" }}>Отменена</option>
                        @endif
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Изменить">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Отмена</a>
            </form>
        </div>
    </div>
@endsection
