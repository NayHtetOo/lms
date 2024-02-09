<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function exams(){
        return $this->belongsTo(Exam::class);
    }
    public function matching_answer(){
        return $this->hasMany(MatchingAnswer::class);
    }
}
