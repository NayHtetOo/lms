<?php

namespace App\Livewire;

use App\Models\Course as ModelsCourse;
use App\Models\Enrollment;
use App\Models\Role;
use LDAP\Result;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Course extends Component
{
    public $search;
    private $courses;
    #[Computed()]
    public function render()
    {
        $search_name = $this->search;
        $enrollment = Enrollment::where('user_id', auth()->user()->id)->pluck('course_id');
        $courses = ModelsCourse::whereIn('id',$enrollment)->get();
        $this->courses = $courses->filter(function($course) use ($search_name){
            // dump("Course Name: " . $course->course_name . ", Search Term: " . $search_name);
            return stripos($course->course_name,$search_name) !== false;
        });

        return view('livewire.course',[
            'courses' => $this->courses,
            'search' => $this->search
        ]);
    }
}
