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

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                >
            </div>

            @php($selectedType = old('type_account', 'government'))
            <div class="mb-4">
                <span class="form-label d-block mb-2">Тип аккаунта</span>
                <div class="btn-group" role="group" aria-label="Тип аккаунта">
                    <input type="radio" class="btn-check" name="type_account" id="type-government" value="government" autocomplete="off" {{ $selectedType === 'government' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="type-government">Госорган</label>

                    <input type="radio" class="btn-check" name="type_account" id="type-business" value="business" autocomplete="off" {{ $selectedType === 'business' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="type-business">Бизнес</label>

                    <input type="radio" class="btn-check" name="type_account" id="type-bank" value="bank" autocomplete="off" {{ $selectedType === 'bank' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="type-bank">Банк</label>
                </div>
                @error('type_account')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">У меня уже есть аккаунт</a>
            </div>
        </form>
    </div>
@endsection
