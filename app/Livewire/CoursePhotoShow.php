<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Computed;

class CoursePhotoShow extends Component
{
    public $courseId;

     #[Computed]
    public function course() {

        $course = Course::where('id', $this->courseId)->first();
        return $course;
    }

    public function mount($courseId) {
        $this->courseId = $courseId;
    }

    public function render()
    {
        return view('livewire.course-photo-show');
    }
}
