<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Essay;
use App\Models\Exam;
use App\Models\Lesson;
use App\Models\Matching;
use App\Models\MultipleChoice;
use App\Models\ShortQuestion;
use App\Models\TrueOrFalse;
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

    #[Computed]
    public function trueOrfalse(){
       return TrueOrFalse::findOrFail($this->exams->id)->get();
    }

    #[Computed]
    public function multipleChoice(){
       return MultipleChoice::findOrFail($this->exams->id)->get();
    }

    #[Computed]
    public function matching(){
       return Matching::findOrFail($this->exams->id)->get();
    }

    #[Computed]
    public function shortQuestion(){
       return ShortQuestion::findOrFail($this->exams->id)->get();
    }

    #[Computed]
    public function essay(){
       return Essay::findOrFail($this->exams->id)->get();
    }

    public function render()
    {
        return view('livewire.exam-view');
    }
}
