<nav class="navbar navbar-expand-lg navbar-dark app-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Лаборатория гипотез</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}" href="{{ route('home') }}">Главная</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('profile') ? ' active' : '' }}" href="{{ route('profile') }}">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('hypothesis.create') ? ' active' : '' }}" href="{{ route('hypothesis.create') }}">Задать гипотезу</a>
                    </li>
                    <li class="nav-item">
                        <span class="navbar-text">{{ Auth::user()->name }}!</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Выйти</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('login') ? ' active' : '' }}" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('register') ? ' active' : '' }}" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

