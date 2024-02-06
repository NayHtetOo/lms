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

    public function mount($id)
    {
        $this->id = $id;
        $this->user_id = auth()->user()->id;
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;

        $exam_answered_users = ExamAnswer::where('exam_id',$this->id)->pluck('user_id');
        $this->examSubmitted = $exam_answered_users->contains(auth()->user()->id);

        // dd($this->examSubmitted);
        if($this->examSubmitted){
            $this->examSummary;
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

         // After a successful submission, set a session flash message
        session()->flash('message', 'Form submitted successfully!');


        // return redirect()->route('courses');

    }
    #[Computed]
    public function examSummary(){
        // exam submitted
        // $true_false_data = [];
        // $multiple_choice_data = [];

        $exam = ExamAnswer::where('exam_id',$this->id)->first();
        $this->examSubmittedDate = $exam->created_at;
        // dd($this->examSubmittedDate);

        $true_false_answer = TrueOrFalseAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $multiple_choice_answer = MultipleChoiceAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $matching_answer = MatchingAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $short_question_answer = ShortQuestionAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();
        $essay_answer = EssayAnswer::where('exam_id',$this->id)->where('user_id',$this->user_id)->get();

        //
        $inputArray = [
            "question_1" => "answer2",
            "question_2" => "answer1",
            "question_3" => "answer3"
        ];

        $compareArray = [
            "question_1" => "answer1",
            "question_2" => "answer2",
            "question_3" => "answer3"
        ];

        $resultArray = [];

        // foreach ($inputArray as $questionKey => $answerValue) {
        //     // Extract question index from the key (e.g., "question_1" -> "1")
        //     $questionIndex = substr($questionKey, strrpos($questionKey, '_') + 1);
        //     dump($questionIndex);
        //     // Create the expected answer key based on the question index
        //     $expectedAnswerKey = "answer_" . $questionIndex;
        //     dump($expectedAnswerKey);
        //     // Check if the answer matches the expected answer from the compare array
        //     if (isset($compareArray[$questionKey]) && $answerValue === $compareArray[$expectedAnswerKey]) {
        //         // If the answer matches, add it to the result array
        //         $resultArray[$questionKey] = $answerValue;
        //     }
        // }
        // dd($resultArray);

        $corrected_matching = $matching_answer->filter(function ($match) {
            $primary_matching = Matching::find($match->matching_id);
            $student_answer = collect(unserialize($match->student_answer));


            $filteredPairs = [];

            foreach ($student_answer as $questionIndex => $answerIndex) {
                $questionKey = "question_" . $questionIndex;
                $answerKey = "answer_" . $answerIndex;

               dump($questionKey);
               dump($answerIndex);
               dump($answerKey);
               // question_1 must be answer_1 ,question_2 must be answer_2 and question_3 must be answer_3

                if (isset($primary_matching[$questionKey]) && isset($primary_matching[$answerKey])) {
                    $filteredPairs[$primary_matching[$questionKey]] = $primary_matching[$answerKey];
                }
            }
            dump($filteredPairs);
        });


        $multiple_choice_data = [
            'correct' => $corrected_matching->count(),
            'origin' => $multiple_choice_answer->count(),
            'grade' => $corrected_matching->sum(function ($answer) {
                $primary_multiple_choice = MultipleChoice::find($answer->multiple_choice_id);
                return collect($primary_multiple_choice->mark)->sum();
            }),
            'total' => $multiple_choice_answer->sum(function ($answer) {
                $primary_multiple_choice = MultipleChoice::find($answer->multiple_choice_id);
                return collect($primary_multiple_choice->mark)->sum();
            })
        ];


        //
        $corrected_ture_false = $true_false_answer->filter(function ($answer) {
            $primary_true_false = TrueOrFalse::find($answer->true_or_false_id);
            return $answer->student_answer == ($primary_true_false->answer == "1" ? "true" : "false");
        });

        $corrected_multiple_choice = $multiple_choice_answer->filter(function ($answer) {
            $primary_multiple_choice = MultipleChoice::find($answer->multiple_choice_id);
            return $answer->student_answer == $primary_multiple_choice->answer;
        });

        $corrected_short_question = $short_question_answer; // short question need to fix received marks / gieven marks
        $corrected_essay = $essay_answer; // essay need to fix received marks / gieven marks


        $true_false_data = $this->questionsData($corrected_ture_false,$true_false_answer,'App\Models\TrueOrFalse','true_or_false_id');
        $multiple_choice_data = $this->questionsData($corrected_multiple_choice,$multiple_choice_answer,'App\Models\MultipleChoice','multiple_choice_id');
        $short_quesiton_data = $this->questionsData($corrected_short_question,$short_question_answer,'App\Models\ShortQuestion','short_question_id');
        $essay_data = $this->questionsData($corrected_essay,$essay_answer,'App\Models\Essay','essay_id');

        $this->gradeMark = $true_false_data['grade'] + $multiple_choice_data['grade'] + $short_quesiton_data['grade'] + $essay_data['grade'];
        $this->baseTotalMark = $true_false_data['total'] + $multiple_choice_data['total'] + $short_quesiton_data['total'] + $essay_data['total'];
        $this->numberOfQuestion = $true_false_data['origin'] + $multiple_choice_data['origin'] + $short_quesiton_data['origin'] + $essay_data['origin'];

        $result = collect([
            'True or False' => $true_false_answer->isNotEmpty() ? collect($true_false_data) : null,
            'Multiple Choice' => $multiple_choice_answer->isNotEmpty() ? collect($multiple_choice_data) : null,
            // 'Matching' => $matching_answer->isNotEmpty() ? $matching_answer : null,
            'Short Question' => $short_question_answer->isNotEmpty() ? collect($short_quesiton_data) : null,
            'Essay' => $essay_answer->isNotEmpty() ? collect($essay_data) : null,
        ])->filter()->all();

        // dd($result);
        return $result;
    }

    public function questionsData($corrected,$answer,$modelName,$idField){
        return [
            'correct' => $corrected->count(),
            'origin' => $answer->count(),
            'grade' => $corrected->sum(function ($answer) use($modelName,$idField) {
                $primary_multiple_choice = $modelName::find($answer->$idField);
                return collect($primary_multiple_choice->mark)->sum();
            }),
            'total' => $answer->sum(function ($answer) use($modelName,$idField) {
                $primary_multiple_choice = $modelName::find($answer->$idField);
                return collect($primary_multiple_choice->mark)->sum();
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
}
