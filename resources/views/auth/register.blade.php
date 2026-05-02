<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DibiEdu</title>
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
                <a href="{{ route('login') }}">Login</a>
            </nav>
        </div>
    </header>

    <main class="auth-page">
        <section class="auth-panel">
            <p class="eyebrow">New Account</p>
            <h1>Register</h1>
            <p>Buat akun untuk mulai mengelola course.</p>

            <form action="{{ route('register.store') }}" method="POST" class="course-form auth-form">
                @csrf

                <div class="form-grid auth-grid">
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <small>{{ $message }}</small>
                        @enderror
                    </label>

                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required>
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

                    <label>
                        <span>Confirm Password</span>
                        <input type="password" name="password_confirmation" required>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-signup">Register</button>
                    <a href="{{ route('login') }}" class="btn">Already Have Account</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
