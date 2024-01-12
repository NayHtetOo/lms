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

    public function course_sections()
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

    public function true_or_falses(){
        return $this->hasMany(TrueOrFalse::class);
    }
    public function multiple_choices(){
        return $this->hasMany(MultipleChoice::class);
    }
    public function short_questions(){
        return $this->hasMany(ShortQuestion::class);
    }
    public function essays(){
        return $this->hasMany(Essay::class);
    }
    public function matchings(){
        return $this->hasMany(Matching::class);
    }
    public function forums(){
        return $this->hasMany(Forum::class);
    }
}
