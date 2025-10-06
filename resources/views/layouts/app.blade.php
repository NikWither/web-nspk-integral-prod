<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Reset CSS -->
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <title>@yield('title', 'Главная страница')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --header-height: 64px;
            --sidebar-width: 260px;
            --bs-primary: rgb(233, 61, 61);
            --bs-primary-rgb: 233, 61, 61;
            --bs-primary-text-emphasis: #701b1b;
            --bs-primary-bg-subtle: #fde7e7;
            --bs-primary-border-subtle: #f4bcbc;
            --bs-link-color: rgb(233, 61, 61);
            --bs-link-color-rgb: 233, 61, 61;
            --bs-link-hover-color: rgb(205, 45, 45);
            --bs-link-hover-color-rgb: 205, 45, 45;
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: rgb(233, 61, 61);
            --bs-btn-border-color: rgb(233, 61, 61);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: rgb(205, 45, 45);
            --bs-btn-hover-border-color: rgb(205, 45, 45);
            --bs-btn-focus-shadow-rgb: 233, 61, 61;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: rgb(180, 36, 36);
            --bs-btn-active-border-color: rgb(180, 36, 36);
            --bs-btn-disabled-bg: rgb(233, 61, 61);
            --bs-btn-disabled-border-color: rgb(233, 61, 61);
        }

        .btn-outline-primary {
            --bs-btn-color: rgb(233, 61, 61);
            --bs-btn-border-color: rgb(233, 61, 61);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: rgb(233, 61, 61);
            --bs-btn-hover-border-color: rgb(233, 61, 61);
            --bs-btn-focus-shadow-rgb: 233, 61, 61;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: rgb(180, 36, 36);
            --bs-btn-active-border-color: rgb(180, 36, 36);
            --bs-btn-disabled-color: rgb(233, 61, 61);
            --bs-btn-disabled-border-color: rgb(233, 61, 61);
        }

        .app-navbar {
            background: linear-gradient(90deg, rgba(233, 61, 61, 0.98) 0%, rgb(233, 61, 61) 100%);
            box-shadow: 0 10px 28px rgba(233, 61, 61, 0.25);
            padding-block: 0.9rem;
        }

        .app-navbar .container-fluid {
            gap: 1.25rem;
        }

        .app-navbar .navbar-brand {
            color: #fff;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.03em;
        }

        .app-navbar .nav-link,
        .app-navbar .navbar-text,
        .app-navbar .btn-link {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.05rem;
            font-weight: 500;
        }

        .app-navbar .nav-link {
            padding: 0.6rem 1rem;
            border-radius: 999px;
            transition: color 0.2s ease, background-color 0.2s ease, opacity 0.2s ease;
        }

        .app-navbar .nav-link:hover,
        .app-navbar .nav-link:focus,
        .app-navbar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.16);
        }

        .app-navbar .navbar-text {
            color: rgba(255, 255, 255, 0.92);
        }

        .app-navbar .btn-link.nav-link {
            color: rgba(255, 255, 255, 0.92);
        }

        .app-navbar .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.55);
        }

        .app-navbar .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 991.98px) {
            .app-navbar .navbar-collapse {
                background: linear-gradient(120deg, rgba(233, 61, 61, 0.98), rgb(233, 61, 61));
                border-radius: 16px;
                padding: 1rem;
                box-shadow: 0 16px 32px rgba(233, 61, 61, 0.25);
            }

            .app-navbar .nav-link {
                padding: 0.75rem 1rem;
            }
        }


        body {
            background-color: #f6f8fb;
        }

        .app-shell {
            display: block;
            min-height: calc(100vh - var(--header-height));
        }

        .sidebar {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            padding: 1.5rem 1.5rem 1.5rem 0;
            display: none;
        }

        .sidebar-handle {
            position: fixed;
            color: #111827;
            top: 50%;
            left: 0;
            transform: translate(-60%, -50%);
            background-color: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.2);
            border-radius: 0 999px 999px 0;
            padding: 0.6rem 0.85rem 0.6rem 0.55rem;
            display: none;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.18);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .sidebar-handle svg {
            width: 32px;
            height: 52px;
            display: block;
            color: #111827;
            transition: color 0.2s ease;
        }


        .sidebar-handle:active {
            transform: translate(-30%, -50%);
        }

        .sidebar-handle:hover svg,
        .sidebar-handle:focus svg {
            color: #e2241b;
        }

        .sidebar-backdrop {
            display: none;
        }

        .main-content {
            padding: clamp(1.5rem, 5vw, 2.75rem);
            transition: transform 0.3s ease;
        }

        .with-sidebar .app-shell {
            display: flex;
            align-items: flex-start;
            gap: clamp(1.25rem, 4vw, 2.5rem);
            padding: clamp(1.25rem, 4vw, 2.5rem);
        }

        .with-sidebar .sidebar {
            display: block;
            position: sticky;
            top: calc(var(--header-height) + clamp(0.75rem, 2vw, 1.5rem));
            height: calc(100vh - var(--header-height) - clamp(1rem, 4vw, 2rem));
            max-height: calc(100vh - var(--header-height) - clamp(1rem, 4vw, 2rem));
            overflow-y: auto;
            width: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            scrollbar-gutter: stable;
        }

        .with-sidebar .main-content {
            padding: 0;
            flex: 1 1 auto;
        }

        @media (max-width: 991.98px) {
            body {
                background-color: #ffffff;
            }

            .with-sidebar .app-shell {
                display: block;
                padding: clamp(1rem, 3vw, 1.5rem);
            }

            .with-sidebar .sidebar {
                position: fixed;
                top: var(--header-height);
                left: 0;
                bottom: 0;
                width: min(80vw, 320px);
                max-height: none;
                height: calc(100vh - var(--header-height));
                border-radius: 0 18px 18px 0;
                transform: translateX(-110%);
                transition: transform 0.3s ease;
                z-index: 1050;
                box-shadow: 0 1.25rem 2.75rem rgba(15, 23, 42, 0.22);
                overflow-y: auto;
                display: block;
            }

            .with-sidebar .sidebar.is-open {
                transform: translateX(0);
            }

            .with-sidebar .sidebar-backdrop {
                position: fixed;
                inset: var(--header-height) 0 0 0;
                background: rgba(15, 23, 42, 0.38);
                backdrop-filter: blur(2px);
                display: block;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
                z-index: 1040;
            }

            .with-sidebar .sidebar-backdrop.is-visible {
                opacity: 1;
                pointer-events: auto;
            }

            .with-sidebar .main-content {
                padding: 0;
            }

            .with-sidebar .sidebar-handle {
                display: inline-flex;
            }

            body.sidebar-open {
                overflow: hidden;
            }

            body.sidebar-open .sidebar-handle {
                opacity: 0;
                pointer-events: none;
            }
        }
    </style>
</head>
@php($bodyClass = trim($__env->yieldContent('body_class', '')))
<body class="{{ $bodyClass }}">
    @include('partials.header')

    <button type="button" class="sidebar-handle d-lg-none" data-sidebar-toggle aria-label="Open sidebar">
        <svg width="24" height="42" viewBox="0 0 24 42" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 5L18 21L6 37" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div class="app-shell">
        <aside class="sidebar" id="appSidebar">
            @hasSection('sidebar')
                @yield('sidebar')
            @else
                @include('partials.sidebar')
            @endif
        </aside>

        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <main class="main-content" id="appMainContent">
            @if (session('status'))
                <div class="container mt-3">
                    <div class="alert alert-success">{{ session('status') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.querySelector('.navbar');
            if (nav) {
                document.documentElement.style.setProperty('--header-height', `${nav.offsetHeight}px`);
            }

            if (!document.body.classList.contains('with-sidebar')) {
                return;
            }

            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleElements = document.querySelectorAll('[data-sidebar-toggle]');

            const closeSidebar = () => {
                sidebar?.classList.remove('is-open');
                backdrop?.classList.remove('is-visible');
                document.body.classList.remove('sidebar-open');
            };

            const openSidebar = () => {
                sidebar?.classList.add('is-open');
                backdrop?.classList.add('is-visible');
                document.body.classList.add('sidebar-open');
            };

            toggleElements.forEach((trigger) => {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    if (sidebar?.classList.contains('is-open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            });

            backdrop?.addEventListener('click', closeSidebar);

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>








