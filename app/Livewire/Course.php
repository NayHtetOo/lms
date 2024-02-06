<?php

namespace App\Livewire;

use App\Models\Course as ModelsCourse;
use App\Models\Enrollment;
use App\Models\Role;
use LDAP\Result;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Course extends Component
{
    public $search;
    private $courses;
    public $buttonLabel = "Learn More";

    use WithPagination;

    #[Computed()]
    public function render()
    {
        $search_name = $this->search;
        $enrollment = Enrollment::where('user_id', auth()->user()->id)->pluck('course_id');
        
        if ($search_name) {
            $courses = ModelsCourse::whereIn('id', $enrollment)
                ->where('course_name', 'LIKE', '%' . $search_name . '%')
                ->paginate(4);
        } else {
            $courses = ModelsCourse::whereIn('id', $enrollment)->paginate(4);
        }

        // $this->courses = $courses->filter(function($course) use ($search_name){
        //     // dump("Course Name: " . $course->course_name . ", Search Term: " . $search_name);
        //     return stripos($course->course_name,$search_name) !== false;
        // });

        return view('livewire.course', [
            'courses' => $courses,
            'search' => $this->search
        ]);
    }
}
