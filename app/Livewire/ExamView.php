<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Essay;
use App\Models\EssayAnswer;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Lesson;
use App\Models\Matching;
use App\Models\MatchingAnswer;
use App\Models\MultipleChoice;
use App\Models\MultipleChoiceAnswer;
use App\Models\ShortQuestion;
use App\Models\ShortQuestionAnswer;
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
    public $user_id;
    public $gradeMark;
    public $baseTotalMark;
    public $examSubmittedDate;
    public $numberOfQuestion;
    public $matching_corrected;
    public $received_mark_per_question;
    public $matching_mark;
    public $summaryView = false;
    public $reviewQuestion = false;

    public function mount($id)
    {
        $this->id = $id;
        $this->user_id = auth()->user()->id;
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;

        $exam_answered_users = ExamAnswer::where('exam_id',$this->id)->pluck('user_id');
        $this->examSubmitted = $exam_answered_users->contains(auth()->user()->id);

        // dd($this->examSubmitted);
        if($this->examSubmitted){
            if($this->reviewQuestion){

            }else{
                $this->summaryView = true;
                $this->examSummary;
            }
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
        // $user_id = auth()->user()->id;
        // dd($this->id);

        ExamAnswer::create([
            'user_id' => $this->user_id,
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

        $this->examSubmitted = true;

         // After a successful submission, set a session flash message
        session()->flash('message', 'Form submitted successfully!');
        // return redirect()->route('courses');

    }
    #[Computed]
    public function examSummary(){
        // exam submitted

        $exam = ExamAnswer::where('exam_id',$this->id)->first();
        $this->examSubmittedDate = $exam->created_at;
        // dd($this->examSubmittedDate);

        $true_false_answer = TrueOrFalseAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $multiple_choice_answer = MultipleChoiceAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $matching_answer = MatchingAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $short_question_answer = ShortQuestionAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $essay_answer = EssayAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();

        $matching_answer->filter(function($answer){
            $matching = Matching::find($answer->matching_id);
            // dump($matching->toArray());
            $matching_question_count = 3;
            $received_mark_per_question = $matching->mark / $matching_question_count;

            $compareArray = [
                "1" => "1", // question 1 must be answer 1
                "2" => "2", // question 2 must be answer 2
                "3" => "3"  // question 3 must be answer 3
            ];
            // student answered matching array
            $inputArray = unserialize($answer->student_answer);

            // Get elements from $inputArray that are not present in $compareArray
            $diff = array_diff_assoc($inputArray, $compareArray);
            // Get elements from $inputArray that are present in $compareArray
            $intersect = array_intersect_assoc($inputArray, $compareArray);

            // Combine the results
            // $combine = $diff + $intersect;
            $this->matching_corrected = $this->matching_corrected + count($intersect);
            // dump($received_mark_per_question);
            // dump($matching_corrected);

            $this->matching_mark = $this->matching_mark + count($intersect) * $received_mark_per_question;
            // dump(count($diff),count($intersect));
            // dd($diff,$intersect,$combine);
        });
        // dump($this->matching_corrected);

        $matching_data = [
            'correct' => $this->matching_corrected,
            'origin' => $matching_answer->count(),
            'grade' => $this->matching_mark,
            'total' => $matching_answer->sum(function ($answer) {
                $primary_question = Matching::find($answer->matching_id);
                return collect($primary_question->mark)->sum();
            })
        ];

        $true_false_data = $this->questionsData($true_false_answer,'App\Models\TrueOrFalse','true_or_false_id');
        $multiple_choice_data = $this->questionsData($multiple_choice_answer,'App\Models\MultipleChoice','multiple_choice_id');
        $short_quesiton_data = $this->questionsData($short_question_answer,'App\Models\ShortQuestion','short_question_id');
        $essay_data = $this->questionsData($essay_answer,'App\Models\Essay','essay_id');

        $this->gradeMark = $true_false_data['grade'] + $multiple_choice_data['grade'] + $matching_data['grade'] + $short_quesiton_data['grade'] + $essay_data['grade'];
        $this->baseTotalMark = $true_false_data['total'] + $multiple_choice_data['total'] + $matching_data['total'] + $short_quesiton_data['total'] + $essay_data['total'];
        $this->numberOfQuestion = $true_false_data['origin'] + $multiple_choice_data['origin'] + $matching_data['origin'] + $short_quesiton_data['origin'] + $essay_data['origin'];

        $result = collect([
            'True or False' => $true_false_answer->isNotEmpty() ? collect($true_false_data) : null,
            'Multiple Choice' => $multiple_choice_answer->isNotEmpty() ? collect($multiple_choice_data) : null,
            'Matching' => $matching_answer->isNotEmpty() ? $matching_data : null,
            'Short Question' => $short_question_answer->isNotEmpty() ? collect($short_quesiton_data) : null,
            'Essay' => $essay_answer->isNotEmpty() ? collect($essay_data) : null,
        ])->filter()->all();

        // dd($result);

        return $result;
    }

    public function questionsData($answer,$modelName,$idField) {
        // need to fix for short question and essay
        if($idField == 'short_question_id' || $idField == 'essay_id'){
            $corrected = $answer;
        }else{
            $corrected = $answer->filter(function ($answer) use($modelName,$idField) {
                $primary_answer = $modelName::find($answer->$idField);
                return $answer->student_answer == $primary_answer->answer;
            });
        }

        return [
            'correct' => $corrected->count(),
            'origin' => $answer->count(),
            'grade' => $corrected->sum(function ($answer) use($modelName,$idField) {
                $corrected_question = $modelName::find($answer->$idField);
                return collect($corrected_question->mark)->sum();
            }),
            'total' => $answer->sum(function ($answer) use($modelName,$idField) {
                $primary_question = $modelName::find($answer->$idField);
                return collect($primary_question->mark)->sum();
            })
        ];
    }

    public function answerQuery($loop, $modelName, $answerId)
    {
        // dd($loop,$modelName,$answerId);
        foreach ($loop as $key => $value) {
            $model = new $modelName; // Create a new instance of the model
            $model->exam_id = $this->id;
            $model->user_id = $this->user_id; // auth()->user()->id;
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
       $multipleChoice = $this->multipleChoice;
       $matching = $this->matching;
       $shortQuestion = $this->shortQuestion;
       $essay = $this->essay;

       $data = collect([
            'true_false' => $trueorfalse,
            'multiple_choice'=> $multipleChoice,
            'matching'=> $matching,
            'short_question'=> $shortQuestion,
            'essay'=> $essay,
        ])->all();

       return $data;
    }
    public function review(){
        // dump($this->id,$this->user_id);
        $this->reviewQuestion = true;
        $this->summaryView = false;
    }
    public function backToSummary(){
        $this->summaryView = true;
        $this->reviewQuestion = false;

    }
}
