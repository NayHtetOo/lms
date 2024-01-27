<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class Home extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.home',[
            'courses' => Course::all(),
            // 'courses' => Course::where('course_category_id',2)->get(),
        ]);
    }
}
