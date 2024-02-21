<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentFinal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
