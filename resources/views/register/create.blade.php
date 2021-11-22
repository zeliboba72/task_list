@extends('layouts.app')
@section('browser-title', 'Регистрация')
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="mt-4 mb-4">Регистрация</h1>
            <form method="POST" action="" class="border rounded p-4">
                @csrf
                <div class="mb-3">
                    <label for="input-login" class="form-label">Логин:</label>
                    <input name="login" type="text" class="form-control" id="input-login" value="{{ old('login') }}" required>
                    @error('login')
                        <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-name" class="form-label">Имя:</label>
                    <input name="name" type="text" class="form-control" id="input-name" value="{{ old('name') }}" required>
                    @error('name')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-surname" class="form-label">Фамилия:</label>
                    <input name="surname" type="text" class="form-control" id="input-surname" value="{{ old('surname') }}" required>
                    @error('surname')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-patronymic" class="form-label">Отчество:</label>
                    <input name="patronymic" type="text" class="form-control" id="input-patronymic" value="{{ old('surname') }}" required>
                    @error('patronymic')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-password" class="form-label">Пароль:</label>
                    <input name="password" type="password" class="form-control" id="input-password" required>
                    @error('password')
                    <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="input-supervisor" class="form-label">Руководитель:</label>
                    <select name="supervisor"
                            class="form-select"
                            id="input-supervisor"
                            aria-label="responsible-person-select"
                    >
                        <option value="">Без руководителя</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('supervisor') == $user->id ? 'selected' : '' }}>
                                {{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Создать">
            </form>
        </div>
    </div>
@endsection
