<?php

namespace App\Models;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'batch_id',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
