@extends('layouts.app')

@section('title', 'Регистрация')

@push('styles')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="form-container">
        <h2 class="mb-4">Регистрация</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
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

            <p class="text-muted small mb-4">Для демо-версии достаточно указать ваше имя — мы остальное сделаем автоматически.</p>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">У меня уже есть аккаунт</a>
            </div>
        </form>
    </div>
@endsection
