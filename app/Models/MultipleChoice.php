<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exams(){
        return $this->belongsTo(Exam::class);
    }
    public function multiple_choice_answer(){
        return $this->hasMany(MultipleChoiceAnswer::class);
    }
}
