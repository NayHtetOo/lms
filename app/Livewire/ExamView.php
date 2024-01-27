<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ExamView extends Component
{
    public $id;
    public $courseID;

    public function mount($id)
    {
        $this->id = $id;
        // dd($this->id);
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_idd;
        // dd($this->courseID);

    }

    #[Computed]
    public function exams(){
       return Exam::findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.exam-view');
    }
}
