<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }}</title>

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkR4j8tBtP9fSZ0xpS5upQ6TZfRjW8Wjk6A=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        >

        <style>
            :root {
                color-scheme: light;
                font-family: Arial, sans-serif;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                background: #f3f4f6;
                color: #111827;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            .shell {
                min-height: 100vh;
            }

            .topbar {
                border-bottom: 1px solid #d1d5db;
                background: #ffffff;
            }

            .topbar-inner {
                max-width: 1120px;
                margin: 0 auto;
                padding: 16px 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .brand {
                font-size: 18px;
                font-weight: 700;
            }

            .nav {
                display: flex;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
            }

            .nav-link {
                font-size: 14px;
                color: #4b5563;
            }

            .nav-link.active {
                color: #111827;
                font-weight: 600;
            }

            .logout-form {
                margin: 0;
            }

            .content {
                max-width: 1120px;
                margin: 0 auto;
                padding: 24px;
            }

            .page-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 24px;
                flex-wrap: wrap;
            }

            .page-title {
                margin: 0 0 6px;
                font-size: 28px;
            }

            .page-copy {
                margin: 0;
                color: #4b5563;
            }

            .toolbar {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap;
            }

            .button,
            button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                min-height: 40px;
                padding: 0 16px;
                border: 0;
                border-radius: 6px;
                background: #111827;
                color: #ffffff;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }

            .button.secondary,
            button.secondary {
                background: #e5e7eb;
                color: #111827;
            }

            .button.danger,
            button.danger {
                background: #b91c1c;
            }

            .panel {
                background: #ffffff;
                border: 1px solid #d1d5db;
                border-radius: 8px;
            }

            .panel-body {
                padding: 24px;
            }

            .status {
                margin-bottom: 16px;
                padding: 12px 16px;
                border: 1px solid #bbf7d0;
                border-radius: 6px;
                background: #f0fdf4;
                color: #166534;
                font-size: 14px;
            }

            .errors {
                margin-bottom: 16px;
                padding: 12px 16px;
                border: 1px solid #fecaca;
                border-radius: 6px;
                background: #fef2f2;
                color: #b91c1c;
                font-size: 14px;
            }

            .table-wrap {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 14px 16px;
                border-bottom: 1px solid #e5e7eb;
                text-align: left;
                font-size: 14px;
                vertical-align: middle;
            }

            th {
                color: #4b5563;
                font-weight: 600;
                background: #f9fafb;
            }

            .actions {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }

            .badge {
                display: inline-flex;
                align-items: center;
                min-height: 24px;
                padding: 0 10px;
                border-radius: 999px;
                background: #e5e7eb;
                color: #374151;
                font-size: 12px;
                font-weight: 600;
            }

            .badge.test {
                background: #dbeafe;
                color: #1d4ed8;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .field.full {
                grid-column: 1 / -1;
            }

            label {
                font-size: 14px;
                font-weight: 600;
            }

            input[type="text"],
            input[type="number"] {
                width: 100%;
                min-height: 42px;
                padding: 0 12px;
                border: 1px solid #cbd5e1;
                border-radius: 6px;
                font-size: 14px;
            }

            .checkbox {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                min-height: 42px;
            }

            .detail-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
            }

            .metric {
                padding: 16px;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                background: #f9fafb;
            }

            .metric-label {
                margin: 0 0 6px;
                color: #6b7280;
                font-size: 13px;
            }

            .metric-value {
                margin: 0;
                font-size: 24px;
                font-weight: 700;
            }

            .pagination {
                padding: 16px 24px;
            }

            @media (max-width: 768px) {
                .content,
                .topbar-inner {
                    padding-left: 16px;
                    padding-right: 16px;
                }

                .form-grid,
                .detail-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <header class="topbar">
                <div class="topbar-inner">
                    <a href="{{ route('properties.index') }}" class="brand">Property Admin</a>

                    <nav class="nav">
                        <a
                            href="{{ route('properties.index') }}"
                            class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}"
                        >
                            Properties
                        </a>
                        <a
                            href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        >
                            Dashboard
                        </a>
                        <form method="post" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="submit" class="secondary">
                                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </header>

            <main class="content">
                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="errors">{{ $errors->first() }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
