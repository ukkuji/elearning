<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DibiEdu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell">
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo" aria-label="DibiEdu home">
                <img src="{{ asset('elearning/images.png') }}" alt="" class="logo-image">
                <span class="logo-text">DibiEdu</span>
            </a>

            <nav class="nav-menu" aria-label="Main navigation">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('register') }}">Register</a>
            </nav>
        </div>
    </header>

    <main class="auth-page">
        <section class="auth-panel">
            <p class="eyebrow">Welcome Back</p>
            <h1>Login</h1>
            <p>Masuk untuk mengelola data course di DibiEdu.</p>

            <form action="{{ route('login.store') }}" method="POST" class="course-form auth-form">
                @csrf

                <div class="form-grid auth-grid">
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required>
                        @error('password')
                            <small>{{ $message }}</small>
                        @enderror
                    </label>
                </div>

                <label class="remember-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                <div class="form-actions">
                    <button type="submit" class="btn-signup">Login</button>
                    <a href="{{ route('register') }}" class="btn">Create Account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
