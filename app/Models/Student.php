<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'course_id',
        'student_number',
        'full_name',
        'email',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
