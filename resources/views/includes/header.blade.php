<header class="bg-primary">
    <div class="container pt-1 pb-1">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('tasks.index') }}" class="fs-3 text-light text-decoration-none">{{ env('APP_NAME') }}</a>
            <div class="d-flex align-items-center">
                @guest
                    <a href="{{ route('register.create') }}" class="btn btn-outline-light me-1">Регистрация</a>
                    <a href="{{ route('auth.create') }}" class="btn btn-outline-light">Войти</a>
                @endguest
                @auth
                    <span class="text-light me-2 d-none d-sm-inline">
                        <strong>
                            {{ auth()->user()->surname }} {{ auth()->user()->name }} {{ auth()->user()->patronymic }}
                        </strong>
                    </span>
                    <form method="POST" action="{{ route('auth.destroy') }}">
                        @csrf
                        <input type="submit" class="btn btn-outline-light" value="Выйти">
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>
