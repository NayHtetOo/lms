<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function exams(){
        return $this->belongsTo(Exam::class);
    }

    public function courses() {
        return $this->belongsTo(Course::class);
    }
    public function forum_discussion(){
        return $this->hasMany(ForumDiscussion::class);
    }
}
