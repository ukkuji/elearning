<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - DibiEdu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-shell">
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="logo" aria-label="DibiEdu home">
                <img src="{{ asset('elearning/images.png') }}" alt="" class="logo-image">
                <span class="logo-text">DibiEdu</span>
            </a>

            <nav class="nav-menu" aria-label="Main navigation">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('courses.index') }}">Courses</a>
            </nav>

            <form action="{{ route('logout') }}" method="POST" class="nav-logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main class="admin-page">
        <section class="course-detail">
            <div class="course-image {{ $course->image_style }}" aria-hidden="true"></div>
            <div>
                <p class="eyebrow">{{ $course->level }} · {{ $course->duration }}</p>
                <h1>{{ $course->title }}</h1>
                <p>{{ $course->description }}</p>
                <strong>Rp {{ number_format($course->price, 0, ',', '.') }}</strong>

                <div class="form-actions">
                    <a href="{{ route('courses.edit', $course) }}" class="btn-signup">Edit</a>
                    <a href="{{ route('courses.index') }}" class="btn">Back</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
