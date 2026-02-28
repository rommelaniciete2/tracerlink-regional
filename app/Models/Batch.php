<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasUuids;
    protected $fillable = [
        'name'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
