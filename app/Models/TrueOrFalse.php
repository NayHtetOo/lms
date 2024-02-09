<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrueOrFalse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exams(){
        return $this->belongsTo(Exam::class);
    }
    public function true_or_false_answer(){
        return $this->hasMany(TrueOrFalseAnswer::class);
    }
}
