<?php

namespace App\Livewire;

use App\Models\Course as ModelsCourse;
use Livewire\Component;

class Course extends Component
{
    public function render()
    {
        return view('livewire.course',[
            'courses' => ModelsCourse::where('course_category_id',2)->get()
        ]);
    }
}
