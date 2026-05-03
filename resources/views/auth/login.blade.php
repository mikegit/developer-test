<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login</title>

        <style>
            :root {
                color-scheme: light;
                font-family: Arial, sans-serif;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: #f5f6f8;
                color: #1f2937;
            }

            .page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
            }

            .panel {
                width: 100%;
                max-width: 420px;
                background: #ffffff;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                padding: 32px;
                box-sizing: border-box;
            }

            h1 {
                margin: 0 0 8px;
                font-size: 24px;
            }

            p {
                margin: 0 0 24px;
                color: #4b5563;
            }

            label {
                display: block;
                margin-bottom: 8px;
                font-size: 14px;
                font-weight: 600;
            }

            input[type="email"],
            input[type="password"] {
                width: 100%;
                height: 44px;
                padding: 0 12px;
                border: 1px solid #cbd5e1;
                border-radius: 6px;
                box-sizing: border-box;
                margin-bottom: 16px;
                font-size: 14px;
            }

            .remember {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
                font-size: 14px;
            }

            button {
                width: 100%;
                height: 44px;
                border: 0;
                border-radius: 6px;
                background: #111827;
                color: #ffffff;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }

            .error {
                margin: 0 0 16px;
                padding: 12px;
                border: 1px solid #fecaca;
                border-radius: 6px;
                background: #fef2f2;
                color: #b91c1c;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <main class="page">
            <section class="panel">
                <h1>Admin Login</h1>
                <p>Use the configured admin account to access the application.</p>

                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif

                <form method="post" action="{{ route('login.store') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', config('setup.admin_email')) }}"
                        required
                        autofocus
                    >

                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>

                    <label class="remember" for="remember">
                        <input id="remember" name="remember" type="checkbox" value="1">
                        <span>Remember me</span>
                    </label>

                    <button type="submit">Sign In</button>
                </form>
            </section>
        </main>
    </body>
</html>
