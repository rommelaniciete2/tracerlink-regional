<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'batch' => ['nullable', 'uuid', 'exists:batches,id'],
        ]);

        $batches = Batch::query()
            ->orderByDesc('name')
            ->get(['id', 'name']);

        $selectedBatchId = $validated['batch'] ?? $batches->first()?->id;

        $courses = Course::query()
            ->when($selectedBatchId, fn ($query) => $query->where('batch_id', $selectedBatchId))
            ->orderBy('name')
            ->get(['id', 'name', 'batch_id']);

        return Inertia::render('Course/Index', [
            'batches' => $batches,
            'selectedBatchId' => $selectedBatchId,
            'courses' => $courses,
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
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());

        return to_route('course.index', ['batch' => $course->batch_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return to_route('course.index', ['batch' => $course->batch_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $batchId = $course->batch_id;
        $course->delete();

        return to_route('course.index', ['batch' => $batchId]);
    }
}
