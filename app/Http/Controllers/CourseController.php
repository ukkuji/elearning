<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('courses.index', [
            'courses' => Course::latest()->paginate(8),
        ]);
    }

    public function create(): View
    {
        return view('courses.create', [
            'course' => new Course(),
            'imageStyles' => $this->imageStyles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Course::create($this->validated($request));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course berhasil ditambahkan.');
    }

    public function show(Course $course): View
    {
        return view('courses.show', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course): View
    {
        return view('courses.edit', [
            'course' => $course,
            'imageStyles' => $this->imageStyles(),
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $course->update($this->validated($request));

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:700'],
            'level' => ['required', 'string', 'max:60'],
            'duration' => ['required', 'string', 'max:60'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'image_style' => ['required', 'string', 'in:img-1,img-2,img-3'],
        ]);
    }

    private function imageStyles(): array
    {
        return [
            'img-1' => 'Blue Teal',
            'img-2' => 'Green Sky',
            'img-3' => 'Gold Orange',
        ];
    }
}
