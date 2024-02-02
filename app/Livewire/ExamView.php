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
use App\Models\TrueOrFalseAnswer;
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
    public $trueorfalseAnswer = [];

    public function mount($id)
    {
        $this->id = $id;
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;
        // true or false input to default value false
        foreach ($this->trueOrfalse as $tof) {
            $this->trueorfalseAnswer[$tof->id] = 'false';
        }
        // dd($this->courseID);
    }

    public function render()
    {
        return view('livewire.exam-view',['questions' => $this->questions]);
    }

    public function examSubmit(){
        // dd($this->trueorfalseAnswer);
        foreach ($this->trueorfalseAnswer as $key => $value) {
            // dd(auth()->user()->id,$key,$value);
            // TrueOrFalseAnswer::create([
            //     'user_id' => auth()->user()->id,
            //     'true_or_false_id' => $key,
            //     'student_answer' => $value
            // ]);
        }

        foreach($this->multipleChoice as $key => $value){
            
            MultipleChoice::create([
                'user_id' => ,
                'multiple_choice_id' => ,
                'student_answer' =>
            ]);
        }
         // After a successful submission, set a session flash message
        session()->flash('message', 'Form submitted successfully!');

        // return redirect()->route('courses');

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
}
