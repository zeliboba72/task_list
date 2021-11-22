@extends('layouts.app')
@section('browser-title', 'Вход')
@section('content')
    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="mt-4 mb-4">Вход</h1>
            <form method="POST" action="{{ route('auth.store') }}" class="border rounded p-4">
                @csrf
                <div class="mb-3">
                    <label for="input-login" class="form-label">Логин:</label>
                    <input name="login" type="text" class="form-control" id="input-login" value="{{ old('login') }}" required>
                </div>
                <div class="mb-3">
                    <label for="input-password" class="form-label">Пароль:</label>
                    <input name="password" type="password" class="form-control" id="input-password" required>
                    @error('password')
                        <p class="m-0 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value="Войти">
            </form>
        </div>
    </div>
@endsection
