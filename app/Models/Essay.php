<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function exam(){
        return $this->hasMany(Exam::class);
    }
}
