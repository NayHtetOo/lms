<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    public $search;
    // public $courses;
    public $buttonLabel = "Learn more";

     public function course($courseid) {
        return redirect()->route('course_view', $courseid);
    }

    public function render()
    {
        $courses = Course::where('course_name','like','%'.$this->search.'%')
                    ->where('visible', 1)
                    ->orderBy('created_at', 'desc')
                    ->paginate(4);

        return view('livewire.home',[
            'courses' => $courses
            // 'courses' => Course::where('course_category_id',2)->get(),
        ])->layout("layouts.app");
    }
}
