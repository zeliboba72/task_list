@extends('layouts.app')
@section('browser-title', 'Создание задачи')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-xl-5">
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
                        <option value="{{ auth()->user()->id }}">Назначить меня</option>
                        @if($subordinates && $subordinates->count())
                            @foreach($subordinates as $subordinate)
                                <option value="{{ $subordinate->id }}" {{ old('responsible_person') == $subordinate->id ? 'selected' : '' }}>
                                    {{ $subordinate->surname }} {{ $subordinate->name }} {{ $subordinate->patronymic }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label for="input-date" class="form-label">Крайний срок:</label>
                    <input name="expiration_date" type="date" class="form-control" id="input-date" required>
                </div>
                <input name="creator" type="hidden" value="{{ auth()->user()->id }}" required>
                <input type="submit" class="btn btn-primary" value="Создать">
                <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">Отмена</a>
            </form>
        </div>
    </div>
@endsection
