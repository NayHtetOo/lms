<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course_sections(){
        return $this->belongsTo(CourseSection::class);
    }

    public function users() {
        return $this->belongsTo(User::class);
    }
}
