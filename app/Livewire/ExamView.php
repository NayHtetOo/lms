<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Essay;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Lesson;
use App\Models\Matching;
use App\Models\MatchingAnswer;
use App\Models\MultipleChoice;
use App\Models\MultipleChoiceAnswer;
use App\Models\ShortQuestion;
use App\Models\TrueOrFalse;
use App\Models\TrueOrFalseAnswer;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use PDO;

class ExamView extends Component
{
    use WithPagination,WithoutUrlPagination;

    public $id;
    public $courseID;
    public $trueorfalseAnswer = [];
    public $multipleChoiceAnswer = [];
    public $matchingAnswer = [];
    public $shortQuestionAnswer = [];
    public $essayAnswer = [];
    public $examSubmitted = false;

    public function mount($id)
    {
        $this->id = $id;
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;

        $exam_answered_users = ExamAnswer::where('exam_id',$this->id)->pluck('user_id');
        $this->examSubmitted = $exam_answered_users->contains(auth()->user()->id);

        // dd($this->examSubmitted);
        if($this->examSubmitted){
            // $this->examSummary;
        }
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
        $user_id = auth()->user()->id;
        // dd($this->id);
        ExamAnswer::create([
            'user_id' => $user_id,
            'exam_id' => $this->id,
            'status' => 1 // exam submit
        ]);

        // $matchingAnswer = MatchingAnswer::first();
        // $answer = $matchingAnswer->student_answer;
        // dd(unserialize($answer));
        // store data to answer table(trueOrfalse,multipleChoice,matching,shortQuestion and Essay)
        $this->answerQuery($this->trueorfalseAnswer,'App\Models\TrueOrFalseAnswer','true_or_false_id');
        $this->answerQuery($this->multipleChoiceAnswer,'App\Models\MultipleChoiceAnswer','multiple_choice_id');
        $this->answerQuery($this->matchingAnswer,'App\Models\MatchingAnswer','matching_id');
        $this->answerQuery($this->shortQuestionAnswer,'App\Models\ShortQuestionAnswer','short_question_id');
        $this->answerQuery($this->essayAnswer,'App\Models\EssayAnswer','essay_id');

         // After a successful submission, set a session flash message
        session()->flash('message', 'Form submitted successfully!');


        // return redirect()->route('courses');

    }
    public function examSummary(){
        // exam submitted
        $trueFalseAnswer = TrueOrFalseAnswer::all();
        // dd($trueFalseAnswer);
    }
    public function answerQuery($loop, $modelName, $answerId)
    {
        // dd($loop,$modelName,$answerId);
        foreach ($loop as $key => $value) {
            $model = new $modelName; // Create a new instance of the model
            $model->exam_id = $this->id;
            $model->user_id = auth()->user()->id;
            $model->$answerId = $key;
            $model->student_answer = $answerId == 'matching_id' ? serialize($value) : $value; // Serialize the array before storing
            $model->save();
        }
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
