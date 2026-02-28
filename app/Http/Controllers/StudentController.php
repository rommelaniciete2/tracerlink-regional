<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'course' => ['nullable', 'integer', 'exists:courses,id'],
        ]);

        $courses = Course::query()
            ->with(['batch:id,name'])
            ->orderBy('name')
            ->get(['id', 'name', 'batch_id'])
            ->map(fn (Course $course) => [
                'id' => $course->id,
                'name' => $course->name,
                'batch_id' => $course->batch_id,
                'batch_name' => $course->batch?->name,
            ])
            ->values();

        $selectedCourseId = isset($validated['course'])
            ? (int) $validated['course']
            : $courses->first()?->id;

        $students = Student::query()
            ->when($selectedCourseId, fn ($query) => $query->where('course_id', $selectedCourseId))
            ->orderBy('full_name')
            ->get(['id', 'course_id', 'student_number', 'full_name', 'email']);

        return Inertia::render('Student/Index', [
            'courses' => $courses,
            'selectedCourseId' => $selectedCourseId,
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $student = Student::create($request->validated());

        return to_route('student.index', ['course' => $student->course_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return to_route('student.index', ['course' => $student->course_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $courseId = $student->course_id;
        $student->delete();

        return to_route('student.index', ['course' => $courseId]);
    }
}
