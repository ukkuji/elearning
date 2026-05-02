<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DibiEdu</title>
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
                <a href="#home">Home</a>
                <a href="#courses">Courses</a>
                <a href="#about">About</a>
                @auth
                    <a href="{{ route('courses.index') }}">Manage</a>
                @endauth
                <a href="#contact">Contact</a>
            </nav>

            @auth
                <a href="{{ route('courses.create') }}" class="btn-signup">Add Course</a>
            @else
                <a href="{{ route('login') }}" class="btn-signup">Login</a>
            @endauth
        </div>
    </header>

    <main>
        <section class="slider" id="home" aria-label="Featured learning programs">
            <input type="radio" name="slide" id="s1" checked>
            <input type="radio" name="slide" id="s2">
            <input type="radio" name="slide" id="s3">

            <div class="hero-content">
                <h1>Belajar Lebih Cepat</h1>
                <p>Upgrade skill digital untuk masa depan</p>
                <a href="#courses" class="btn-signup">Mulai Sekarang</a>
            </div>

            <div class="slides">
                <div class="slide">
                    <img src="{{ asset('elearning/img/slide1.webp') }}" alt="Students learning online">
                </div>
                <div class="slide">
                    <img src="{{ asset('elearning/img/slide2.jpg') }}" alt="Digital education workspace">
                </div>
                <div class="slide">
                    <img src="{{ asset('elearning/img/slide3.webp') }}" alt="Online course presentation">
                </div>
            </div>

            <div class="dots" aria-label="Choose slide">
                <label for="s1" class="dot d1"><span>Slide 1</span></label>
                <label for="s2" class="dot d2"><span>Slide 2</span></label>
                <label for="s3" class="dot d3"><span>Slide 3</span></label>
            </div>
        </section>

        <section class="why" id="about">
            <div class="container-why">
                <h2 class="title">Why Choose DibiEdu?</h2>
                <p class="subtitle">
                    Our platform is designed to provide a seamless and effective learning experience,
                    ensuring you gain the skills you need to succeed.
                </p>

                <div class="card-wrapper">
                    <article class="card">
                        <div class="icon" aria-hidden="true">Book</div>
                        <h3>Online Material</h3>
                        <p>
                            Access a vast library of high-quality learning materials, including videos,
                            articles, and interactive content.
                        </p>
                    </article>

                    <article class="card">
                        <div class="icon" aria-hidden="true">Quiz</div>
                        <h3>Quizzes & Assignments</h3>
                        <p>
                            Test your knowledge and reinforce your learning with engaging quizzes
                            and practical assignments.
                        </p>
                    </article>

                    <article class="card">
                        <div class="icon" aria-hidden="true">Cert</div>
                        <h3>Certificates</h3>
                        <p>
                            Earn certificates upon completion of courses, showcasing your achievements
                            and enhancing your credentials.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="courses" id="courses">
            <div class="container-course">
                <h2 class="section-title">Featured Courses</h2>

                <div class="course-grid">
                    @forelse ($courses as $course)
                        <article class="course-card">
                            <div class="course-image {{ $course->image_style }}" aria-hidden="true"></div>
                            <p class="course-meta">{{ $course->level }} · {{ $course->duration }}</p>
                            <h3>{{ $course->title }}</h3>
                            <p>{{ $course->description }}</p>
                            <div class="course-footer">
                                <strong>Rp {{ number_format($course->price, 0, ',', '.') }}</strong>
                                <a href="{{ route('courses.show', $course) }}">Detail</a>
                            </div>
                        </article>
                    @empty
                        <article class="course-card">
                            <div class="course-image img-1" aria-hidden="true"></div>
                            <h3>No Courses Yet</h3>
                            <p>Tambahkan course pertama lewat halaman CRUD.</p>
                        </article>
                    @endforelse
                </div>

                <div class="btn-wrapper">
                    @auth
                        <a href="{{ route('courses.index') }}" class="btn">View All Courses</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Login to Manage Courses</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="footer" id="contact">
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <p class="copyright">
            &copy; 2026 DibiEdu. All rights reserved.
        </p>
    </footer>

    <script>
        const slides = [...document.querySelectorAll('input[name="slide"]')];
        let currentSlide = 0;

        window.setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].checked = true;
        }, 4000);
    </script>
</body>
</html>
