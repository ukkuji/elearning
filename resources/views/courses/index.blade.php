<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - DibiEdu</title>
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
                <a href="{{ route('courses.create') }}">Add Course</a>
            </nav>

            <form action="{{ route('logout') }}" method="POST" class="nav-logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main class="admin-page">
        <section class="admin-header">
            <div>
                <p class="eyebrow">Course CRUD</p>
                <h1>Manage Courses</h1>
                <p>Tambah, lihat, edit, dan hapus course yang tampil di website DibiEdu.</p>
            </div>
            <a href="{{ route('courses.create') }}" class="btn-signup">Add Course</a>
        </section>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <section class="table-panel">
            <div class="table-wrap">
                <table class="course-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Level</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td>
                                    <strong>{{ $course->title }}</strong>
                                    <span>{{ \Illuminate\Support\Str::limit($course->description, 90) }}</span>
                                </td>
                                <td>{{ $course->level }}</td>
                                <td>{{ $course->duration }}</td>
                                <td>Rp {{ number_format($course->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('courses.show', $course) }}">View</a>
                                        <a href="{{ route('courses.edit', $course) }}">Edit</a>
                                        <form action="{{ route('courses.destroy', $course) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus course ini?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">Belum ada course. Tambahkan course pertama.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $courses->links() }}
            </div>
        </section>
    </main>
</body>
</html>
