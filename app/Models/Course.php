<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course_category() {
        return $this->belongsTo(CourseCategory::class);
    }

    public function course_sections() {
        return $this->hasMany(CourseSection::class);
    }

    public function zoom_meetings() {
        return $this->hasManyThrough(ZoomMeeting::class, CourseSection::class);
    }

    public function enrollments(){
        return $this->hasMany(Enrollment::class);
    }

    public function exams(){
        return $this->hasMany(Exam::class);
    }

    public function forums () {
        return $this->hasMany(Forum::class);
    }
}
