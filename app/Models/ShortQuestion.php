<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exams(){
        return $this->belongsTo(Exam::class);
    }
    public function short_question_answer(){
        return $this->hasMany(ShortQuestionAnswer::class);
    }
}
