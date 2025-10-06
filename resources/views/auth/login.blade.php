@extends('layouts.app')

@section('title', 'Вход')

@push('styles')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="form-container">
        <h2 class="mb-4">Вход в систему</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">Имя</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Войти</button>
        </form>

        <p class="text-muted small mt-4 mb-0">Нет аккаунта? <a class="text-decoration-none" href="{{ route('register') }}">Зарегистрируйтесь за минуту</a>.</p>
    </div>
@endsection
