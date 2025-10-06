@extends('layouts.sidebar')

@section('title', 'Профиль')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        .profile-sidebar .list-group {
            width: 100%;
            --bs-list-group-border-radius: 0;
        }

        .profile-sidebar .list-group-item,
        .profile-sidebar .list-group-item:first-child,
        .profile-sidebar .list-group-item:last-child,
        .profile-sidebar .list-group-item:focus {
            border-radius: 0 !important;
        }

        .profile-sidebar .list-group-item {
            display: block;
            width: 100%;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1.05rem;
        }

        .profile-sidebar .list-group-item + .list-group-item {
            margin-top: 0.35rem;
        }

        .profile-sidebar .list-group-item-action {
            border-left: 4px solid transparent;
        }

        .profile-sidebar .list-group-item-action.active {
            font-weight: 600;
            border-left-color: #e2241b;
        }
    </style>

@endpush

@section('sidebar-content')
    <div class="profile-sidebar">
        <div class="profile-sidebar__mobile-head d-lg-none d-flex justify-content-between align-items-center mb-3">
            <h5 class="sidebar-title mb-0">Меню профиля</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm" data-sidebar-toggle>
                Закрыть
            </button>
        </div>
        <h5 class="sidebar-title d-none d-lg-block">Меню профиля</h5>
        <div class="list-group">
            <button type="button" class="list-group-item list-group-item-action active" data-toggle-section="overview">
                Мои гипотезы
            </button>
            <button type="button" class="list-group-item list-group-item-action" data-toggle-section="organization">
                <a href="/hypothesis">Задать гипотезу</a>
            </button>
            <button type="button" class="list-group-item list-group-item-action" data-toggle-section="security">
                Профиль и безопасность
            </button>
            <button type="button" class="list-group-item list-group-item-action" data-toggle-section="notifications">
                Инструкция
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php($user = $user ?? Auth::user())
    @php($hypotheses = $hypotheses ?? collect())
    <div class="profile-content container-fluid py-4">
        <div class="profile-header d-flex align-items-start align-items-lg-center justify-content-between flex-column flex-lg-row gap-3 gap-lg-4 mb-4">
            <div>
                <h1 class="mb-1">Профиль</h1>
                <p class="text-muted mb-0">Управляйте личными данными, настройками организации и уведомлениями.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary d-lg-none" data-sidebar-toggle>
                Меню профиля
            </button>
        </div>

        <section class="profile-section active" data-section="overview">
            @include('profile.sections.overview', ['user' => $user, 'hypotheses' => $hypotheses])
        </section>

        <section class="profile-section" data-section="organization">
            @include('profile.sections.organization', ['user' => $user])
        </section>

        <section class="profile-section" data-section="security">
            @include('profile.sections.security', ['user' => $user])
        </section>

        <section class="profile-section" data-section="notifications">
            @include('profile.sections.notifications')
        </section>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const triggers = document.querySelectorAll('[data-toggle-section]');
        const sections = document.querySelectorAll('.profile-section');

        const activateSection = (key) => {
            sections.forEach(section => {
                section.classList.toggle('active', section.dataset.section === key);
            });

            triggers.forEach(trigger => {
                trigger.classList.toggle('active', trigger.dataset.toggleSection === key);
            });
        };

        triggers.forEach(trigger => {
            trigger.addEventListener('click', () => {
                activateSection(trigger.dataset.toggleSection);
            });
        });
    });
</script>
@endpush

