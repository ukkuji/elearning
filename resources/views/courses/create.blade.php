<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course - DibiEdu</title>
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
        <section class="admin-header compact">
            <div>
                <p class="eyebrow">Create</p>
                <h1>Add Course</h1>
            </div>
            <a href="{{ route('courses.index') }}" class="btn">Back</a>
        </section>

        <section class="form-panel">
            <form action="{{ route('courses.store') }}" method="POST" class="course-form">
                @include('courses.partials.form')

                <div class="form-actions">
                    <button type="submit" class="btn-signup">Save Course</button>
                    <a href="{{ route('courses.index') }}" class="btn">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
