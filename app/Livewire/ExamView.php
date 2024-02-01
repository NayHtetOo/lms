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
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ExamView extends Component
{
    use WithPagination,WithoutUrlPagination;

    public $id;
    public $courseID;

    public function mount($id)
    {
        $this->id = $id;
        // dd($this->id);
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;
        // dd($this->courseID);
        // dd($this->questions);

    }

    #[Computed]
    public function questions(){
       $trueorfalse = $this->trueOrfalse;
       $matching = $this->matching;
       $shortQuestion = $this->shortQuestion;
       $essay = $this->essay;
       $multipleChoice = $this->multipleChoice;

       $data = collect([
            'true_false' => $trueorfalse,
            'matching'=> $matching,
            'short_question'=> $shortQuestion,
            'essay'=> $essay,
            'multiple_choice'=> $multipleChoice
        ])->all();

       return $data;
    }

    #[Computed]
    public function exams(){
    //    $exam = Exam::findOrFail($this->id);
    //    dd($exam->toArray());
       return Exam::findOrFail($this->id);
    }

    #[Computed]
    public function trueOrfalse(){
        return  TrueOrFalse::where('exam_id',$this->exams->id)->get();
        // return  TrueOrFalse::paginate(5);
    }

    #[Computed]
    public function multipleChoice(){
        // dd('hello');
        return MultipleChoice::where('exam_id',$this->exams->id)->get();
    }

    #[Computed]
    public function matching(){
       return Matching::where('exam_id',$this->exams->id)->get();
    }

    #[Computed]
    public function shortQuestion(){
       return ShortQuestion::where('exam_id',$this->exams->id)->get();
    }

    #[Computed]
    public function essay(){
       return Essay::where('exam_id',$this->exams->id)->get();
    }

    public function render()
    {
        return view('livewire.exam-view',['questions' => $this->questions]);
    }
}
