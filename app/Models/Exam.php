<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $dates = ['start_date_time', 'end_date_time'];


    protected function getStartFullDateAttribute()
    {
        return "{$this->start_date_time->isoFormat('dddd')}, {$this->start_date_time->format('d F Y, h:i A')}";;
    }
    protected function getEndFullDateAttribute()
    {
        return "{$this->end_date_time->isoFormat('dddd')}, {$this->end_date_time->format('d F Y, h:i A')}";;
    }

    public function course_section()
    {
        return $this->belongsTo(CourseSection::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function exam_attachments()
    {
        return $this->hasMany(ExamAttachment::class);
    }
}
