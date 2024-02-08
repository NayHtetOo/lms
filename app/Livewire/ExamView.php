<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Enrollment;
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
class ExamView extends Component
{
    use WithPagination,WithoutUrlPagination;

    public $id,$courseID;
    public $trueorfalseAnswer, $multipleChoiceAnswer, $matchingAnswer, $shortQuestionAnswer, $essayAnswer = [];

    public $user_id,$gradeMark,$baseTotalMark,$examSubmittedDate,$numberOfQuestion,$matching_corrected;
    public $received_mark_per_question, $matching_mark, $roleName;

    public $isAdmin,$isTeacher,$isStudent,$isGuest = false;
    public $summaryView,$reviewQuestion,$checkAnsweredPaper,$isExamSubmittedStudent,$examSubmitted = false;
    public $trueOrfalse,$multipleChoice,$matching,$shortQuestion,$essay,$exam_answered_users,$checkedCurrentUser;
    public $questionStatus = false;

    public function mount($id)
    {
        $this->id = $id;
        $this->user_id = auth()->user()->id;
        // dd($this->user_id);
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;
        $enrollment = Enrollment::where('user_id',$this->user_id)->where('course_id',$this->exams->course_id)->first();

        $this->role($enrollment->role->name); // defined role [ admin , teacher ,student ]

        $this->exam_answered_users = ExamAnswer::where('exam_id',$this->id)->pluck('user_id');
        $this->examSubmitted = $this->exam_answered_users->contains(auth()->user()->id);

        // dd($this->examSubmitted);
        if($this->examSubmitted && $this->isStudent){
            if($this->reviewQuestion){

            }else{
                $this->summaryView = true;
                $this->examSummary;
            }
        }
        if($this->isTeacher){
            // dd('I am teacher');
            // $this->checkAnsweredPaper = true;  // test

            $this->isExamSubmittedStudent = true;
            $this->submittedStudents;
        }

            // dd("student");

        $this->allQuestion;

        // dd($this->courseID);
    }
    #[Computed]
    public function allQuestion(){

        $this->trueOrfalse = TrueOrFalse::where('exam_id',$this->exams->id)->get();
        $this->multipleChoice = MultipleChoice::where('exam_id',$this->exams->id)->get();
        $this->matching = Matching::where('exam_id',$this->exams->id)->get();
        $this->shortQuestion = ShortQuestion::where('exam_id',$this->exams->id)->get();
        $this->essay = Essay::where('exam_id',$this->exams->id)->get();

        // true or false input to default value false
        // foreach ($this->trueOrfalse as $tof) {
        //     // dump($tof->answer);
        //     $this->trueorfalseAnswer[$tof->id] = false;
        // }
    }
    #[Computed]
    public function submittedStudents(){
        $exam_answered_users = ExamAnswer::where('exam_id',$this->id)->get();
        $this->exam_answered_users = $exam_answered_users;
        //    dd($this->trueOrfalse);
    }

    public function checkAnsewer($userID,$examID){
        // dd($userID,$examID);
        $this->isExamSubmittedStudent = false;
        $this->checkAnsweredPaper = true;
        $this->checkedCurrentUser = User::find($userID);

        // true or false black check
        $true_false = TrueOrFalse::where('exam_id',$examID)->get();
        $this->trueOrfalse = $true_false;

        $true_false_answer = TrueOrFalseAnswer::where('exam_id',$examID)->where('user_id',$userID)->get();
        $true_false_answer->filter(function($default){
            // dump($default->toArray());
            return $this->trueorfalseAnswer[$default->true_or_false_id] = $default->student_answer;
        });

        // multipel choice block check
        $multiple_choice = MultipleChoice::where('exam_id',$examID)->get();
        $this->multipleChoice = $multiple_choice;
        // dd($this->multipleChoice->toArray());
        $multiple_choice_answer = MultipleChoiceAnswer::where('exam_id',$examID)->where('user_id',$userID)->get();
        $multiple_choice_answer->filter(function($default){
            // dump($default->student_answer);
            return $this->multipleChoiceAnswer[$default->multiple_choice_id] = $default->student_answer;
        });

        // multipel choice block check
        $matching = Matching::where('exam_id',$examID)->get();
        $this->matching = $matching;
        // dd($this->multipleChoice->toArray());
        $matching_answer = MatchingAnswer::where('exam_id',$examID)->where('user_id',$userID)->get();
        $matching_answer->filter(function($default){
            // dump($default->student_answer);
            $inputArray = unserialize($default->student_answer);
            // dump($inputArray);
            return $this->matchingAnswer[$default->matching_id] = $inputArray;
        });

        // dump($this->matchingAnswer);
        // foreach ($this->matchingAnswer as $key => $ma) {
        //     foreach ($ma as $m) {
        //         dump($m);
        //     }
        // }



        // $this->matching->filter(function($row){
        //     dump($row->toArray());
        //     dump($row->answer);
        //     dump($this->matchingAnswer);
        //     $student_answer = $this->matchingAnswer[$row->id];
        //     if($row->answer == $student_answer){
        //         dump('True');
        //     }else{
        //         dump('False');
        //     }

        // });

    }
    #[Computed]
    public function role($role){
        if($role == 'admin'){
            $this->isAdmin = true;
        }elseif($role == 'teacher'){
            // dd('hello');
            $this->isTeacher = true;
            $this->summaryView = false;

        }elseif($role == 'student'){
            $this->isStudent = true;
        }else{
            $this->isGuest = true;
        }
    }

    public function render()
    {
        return view('livewire.exam-view')->layout("layouts.app");
    }

    public function examSubmit(){


        // dd($this->trueorfalseAnswer);
        // $user_id = auth()->user()->id;
        // dd($this->id);
        $this->questionStatus = true;
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

    // #[Computed]
    // public function trueOrfalse(){
    //     return  TrueOrFalse::where('exam_id',$this->exams->id)->get();
    // }

    // #[Computed]
    // public function multipleChoice(){
    //     // dd('hello');
    //     return MultipleChoice::where('exam_id',$this->exams->id)->get();
    // }

    public function review(){
        // dump($this->id,$this->user_id);
        $this->reviewQuestion = true;
        $this->summaryView = false;
    }
    public function backToSummary(){
        $this->summaryView = true;
        $this->reviewQuestion = false;
    }
    public function backToSumittedStudent(){
        $this->isExamSubmittedStudent = true;
        $this->checkAnsweredPaper = false;
    }
}
