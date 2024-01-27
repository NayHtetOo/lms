<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Lesson;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CourseView extends Component
{
    public Course $currentCourse;

    public $currentCourseSection;
    public $participants;

    public $lessons;
    public $exams;
    public $assignments;
    public $section_id;
    public $id;

    public function mount($id)
    {
        $this->id = $id;
        $this->currentCourse = Course::findOrFail($id);
        $this->section_id = $this->currentCourse->id;
        $this->currentCourseSection = CourseSection::where('course_id',$this->section_id)->get();
        $this->participants = Enrollment::all();

        $this->lessons = Lesson::where('course_id',$id)->where('course_section_id',$this->section_id)->get();
        $this->exams = Exam::where('course_id',$id)->where('course_section_id',$this->section_id)->get();
        $this->assignments = Assignment::where('course_id',$id)->where('course_section_id',$this->section_id)->get();
    }

    #[Computed]
    public function currentCourse(){

    }

    #[Computed]
    public function currentCourseSection(){

    }
    #[Computed]
    public function participants(){

    }

    #[Computed]
    public function exams(){

    }

    #[Computed]
    public function assignments(){

    }

    #[Computed]
    public function lessons(){
        return Lesson::where('course_id',$this->id)->where('course_section_id',$this->section_id)->get();
    }

    public function render()
    {
        return view('livewire.course-view');
    }
}
