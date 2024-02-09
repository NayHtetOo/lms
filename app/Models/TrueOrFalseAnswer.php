<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrueOrFalseAnswer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function true_or_falses(){
    //     return $this->belongsTo(TrueOrFalse::class);
    // }

    public function true_or_false(){
        return $this->belongsTo(TrueOrFalse::class);
    }
}
