<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;

class LessonView extends Component
{
    public Lesson $lesson;
    public $courseID;

    public function mount($id)
    {
        $this->lesson = Lesson::findOrFail($id);
        $this->courseID = Course::findOrFail($this->lesson->course_id)->course_ID;
        // dd($this->courseID);
    }

    public function render()
    {
        return view('livewire.lesson-view')->layout("layouts.app");
    }
}
