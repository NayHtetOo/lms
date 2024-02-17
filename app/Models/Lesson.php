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
    public function courses(){
        return $this->belongsTo(Course::class);
    }
    public function course_sections() {
        return $this->belongsTo(CourseSection::class);
    }
    public function lesson_tutorials(){
        return $this->hasMany(LessonTutorial::class);
    }

}
