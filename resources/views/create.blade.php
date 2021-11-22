@extends('layouts.app')
@section('browser-title', 'Создание задачи')
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="mt-4 mb-4">Создание задачи</h1>
            <form method="POST" action="{{ route('tasks.store') }}" class="border rounded p-4">
                @csrf
                <div class="mb-3">
                    <label for="input-title" class="form-label">Заголовок:</label>
                    <input name="title" type="text" class="form-control" id="input-title" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-description" class="form-label">Описание:</label>
                    <textarea name="description" class="form-control" id="input-description" required>{{ old('description') }}</textarea>
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
                        <option value="low"  {{ old('execution') === "low" ? 'selected' : '' }}>Низкий</option>
                        <option value="medium" {{ old('execution') === "medium" ? 'selected' : '' }}>Средний</option>
                        <option value="high" {{ old('execution') === "high" ? 'selected' : '' }}>Высокий</option>
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
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('responsible_person') == $user->id ? 'selected' : '' }}>
                                {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="input-date" class="form-label">Крайний срок:</label>
                    <input name="expiration_date" type="date" class="form-control" id="input-date" required>
                </div>
                @if(Auth::user())
                    <input type="hidden" value="{{ Auth::user()->id }}">
                @endif
                <input type="hidden" value="1" name="creator" required>
                <input type="submit" class="btn btn-primary" value="Создать">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Отмена</a>
            </form>
        </div>
    </div>
@endsection
