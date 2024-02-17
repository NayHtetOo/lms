<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTutorial extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lessons(){
        return $this->belongsTo(Lesson::class);
    }
}
