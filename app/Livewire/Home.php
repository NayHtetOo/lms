<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class Home extends Component
{
    public $search;
    public $courses;
    public $buttonLabel = "Learn more";

    public function render()
    {
        $this->courses = Course::where('course_name','like','%'.$this->search.'%')->get();
        return view('livewire.home',[
            'courses' => $this->courses
            // 'courses' => Course::where('course_category_id',2)->get(),
        ]);
    }
}
