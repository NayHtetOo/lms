<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function lesson_contents()
    // {
    //     return $this->hasMany(LessonContent::class);
    // }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    function course_sections() {
        return $this->belongsTo(CourseSection::class);
    }
}
