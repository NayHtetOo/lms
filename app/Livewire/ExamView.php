<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Essay;
use App\Models\EssayAnswer;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Grade;
use App\Models\Matching;
use App\Models\MatchingAnswer;
use App\Models\MultipleChoice;
use App\Models\MultipleChoiceAnswer;
use App\Models\ShortQuestion;
use App\Models\ShortQuestionAnswer;
use App\Models\TrueOrFalse;
use App\Models\TrueOrFalseAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ExamView extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id, $courseID;
    public $trueorfalseAnswer  = [], $multipleChoiceAnswer = [], $matchingAnswer = [], $shortQuestionAnswer = [], $essayAnswer = [];

    public $user_id, $gradeMark, $baseTotalMark, $examSubmittedDate, $numberOfQuestion, $matching_corrected;
    public $received_mark_per_question, $matching_mark, $roleName;

    public $isAdmin = false, $isTeacher = false, $isStudent = false, $isGuest = false;
    public $summaryView = false, $checkAnsweredPaper = false, $isExamSubmittedStudent = false, $examSubmitted = false;
    public $trueOrfalse, $multipleChoice, $matching, $shortQuestion, $essay, $exam_answered_users, $checkedCurrentUser;
    public $shortQuestionReceiveMark = [], $essayReceiveMark = [];
    public $examStatus, $gradeName, $questionType;
    protected $listener = ["decreaseTimer"];
    public $startAnswer = false;
    public $examDuration = 180;
    public $isExamPaperOpen = false;
    public $pageNumber = 1;
    public $flattenedErrors;
    public $seconds;
    public $minutes;
    public $duration;
    public $timer = 60;
    public $isEditExam;
    public $exam_name,$start_date_time,$end_date_time,$description,$duration_field;
    // protected $casts = [
    //     'end_date_time' => 'date:Y-m-d',
    //     'start_date_time' => 'date:Y-m-d',
    // ];

    public function mount($id)
    {
        $this->id = $id;
        $this->user_id = auth()->user()->id;
        // dd($this->user_id);
        $this->courseID = Course::findOrFail($this->exams->course_id)->course_ID;
        $enrollment = Enrollment::where('user_id', $this->user_id)->where('course_id', $this->exams->course_id)->first();

        $this->role($enrollment->role->name); // defined role [ admin , teacher ,student ]

        $this->exam_answered_users = ExamAnswer::where('exam_id', $this->id)->pluck('user_id');
        $this->examSubmitted = $this->exam_answered_users->contains(auth()->user()->id);

        // dd($this->examSubmitted);
        if ($this->examSubmitted && $this->isStudent) {
            // when click review by sutdent
            $this->examSummary;
        }

        if ($this->isTeacher) {
            // dd('I am teacher');
            // $this->checkAnsweredPaper = true;  // test

            $this->isExamSubmittedStudent = true;
            $this->submittedStudents;
        }
        // student
        $this->allQuestion;
        $this->duration = $this->exams->duration;

        $startDate = \Carbon\Carbon::parse($this->exams->start_date_time);
        $endDate = \Carbon\Carbon::parse($this->exams->end_date_time);
        $todayDate = \Carbon\Carbon::now('Asia/Yangon')->format('y-m-d H:i:s');
        $currentDate = \Carbon\Carbon::parse($todayDate);

        if ($currentDate > $startDate && $currentDate < $endDate && session()->get('seconds') == null && session()->get('mins') == null) {
            session(['seconds' => 60, 'mins' => $this->exams->duration]);
        }

        $this->pageNumber = $this->findFirstNonEmptyPage();
    }

    public function findFirstNonEmptyPage()
    {
        $pageNumber = 1;
        while ($pageNumber <= 5 && !$this->isNotEmptyPage($pageNumber)) {
            $pageNumber++;
        }
        return $pageNumber <= 5 ? $pageNumber : 1;
    }

    public function answerStart()
    {
        $this->isExamPaperOpen = true;
        $this->startAnswer = true;
        session(['startAnswer' => $this->startAnswer]);
    }

    public function decreaseTimer()
    {
        $startDate = \Carbon\Carbon::parse($this->exams->start_date_time);
        $endDate = \Carbon\Carbon::parse($this->exams->end_date_time);
        $todayDate = \Carbon\Carbon::now('Asia/Yangon')->format('y-m-d H:i:s');
        $currentDate = \Carbon\Carbon::parse($todayDate);

        $this->seconds = session()->get('seconds', 60);
        $this->minutes = session()->get('mins', $this->exams->duration);
        // dd($seconds, $minutes);

        if ($currentDate > $startDate && $currentDate < $endDate) {
            if ($this->seconds > 0) {
                $this->seconds--;
                session(['seconds' => $this->seconds]);

                if ($this->seconds == 0) {
                    $this->minutes--;
                    session(["seconds" => 59]);
                    session(['mins' => $this->minutes]);

                    if ($this->minutes == 0) {
                        session(["seconds" => null]);
                        session(["mins" => null]);
                        $this->examSubmit();
                    }
                }
            } else {
                $this->startAnswer = false;
            }
        } else {
            session(['seconds' => 60, 'mins' => $this->exams->duration]);
        }
    }

    public function goToNextPage()
    {
        $nextPageNumber = $this->pageNumber + 1;
        // loop to reach the value is empty
        while ($nextPageNumber <= 5 && !$this->isNotEmptyPage($nextPageNumber)) {
            $nextPageNumber++;
        }
        // value is not empty and display the current page
        if ($nextPageNumber <= 5) {
            $this->pageNumber = $nextPageNumber;
        }
    }

    public function goToPrevPage()
    {
        $prevPageNumber = $this->pageNumber - 1;
        // loop to reach the value is empty
        while ($prevPageNumber >= 1 && !$this->isNotEmptyPage($prevPageNumber)) {
            $prevPageNumber--;
        }

        if ($prevPageNumber >= 1) {
            $this->pageNumber = $prevPageNumber;
        }
    }


    public function isNotEmptyPage($pageNumber)
    {
        // dd($pageNumber);
        $this->trueOrfalse = TrueOrFalse::where('exam_id', $this->exams->id)->get();
        $this->multipleChoice = MultipleChoice::where('exam_id', $this->exams->id)->get();
        $this->matching = Matching::where('exam_id', $this->exams->id)->get();
        $this->shortQuestion = ShortQuestion::where('exam_id', $this->exams->id)->get();
        $this->essay = Essay::where('exam_id', $this->exams->id)->get();

        switch ($pageNumber) {
            case 1:
                return $this->trueOrfalse->isNotEmpty();
            case 2:
                return $this->multipleChoice->isNotEmpty();
            case 3:
                return $this->matching->isNotEmpty();
            case 4:
                return $this->shortQuestion->isNotEmpty();
            case 5:
                return $this->essay->isNotEmpty();
            default:
                return false;
        }
    }

    #[Computed]
    public function studentAccess()
    {
        $enrollment = Enrollment::where('user_id', auth()->user()->id)->first();
        return $enrollment;
    }


    #[Computed]
    public function allQuestion()
    {
        $this->trueOrfalse = TrueOrFalse::where('exam_id', $this->exams->id)->get();
        $this->multipleChoice = MultipleChoice::where('exam_id', $this->exams->id)->get();
        $this->matching = Matching::where('exam_id', $this->exams->id)->get();
        $this->shortQuestion = ShortQuestion::where('exam_id', $this->exams->id)->get();
        $this->essay = Essay::where('exam_id', $this->exams->id)->get();
    }

    #[Computed]
    public function submittedStudents()
    {
        $exam_answered_users = ExamAnswer::where('exam_id', $this->id)->get();
        $this->exam_answered_users = $exam_answered_users;
        //    dd($this->trueOrfalse);
    }

    public function checkAnswer($userID, $examID)
    {
        // dd($userID,$examID);

        $this->shortQuestionReceiveMark = [];
        $this->essayReceiveMark = [];
        $this->isExamSubmittedStudent = false;
        $this->checkAnsweredPaper = true;

        $this->checkedCurrentUser = User::find($userID);

        // true or false black check
        $true_false_answer = TrueOrFalseAnswer::where('exam_id', $examID)->where('user_id', $userID)->get();
        $true_false_answer->filter(function ($default) {
            return $this->trueorfalseAnswer[$default->true_or_false_id] = $default->student_answer;
        });
        $this->trueOrfalse = $true_false_answer;

        // multiple choice block check
        $multiple_choice_answer = MultipleChoiceAnswer::where('exam_id', $examID)->where('user_id', $userID)->get();
        $multiple_choice_answer->filter(function ($default) {
            return $this->multipleChoiceAnswer[$default->multiple_choice_id] = $default->student_answer;
        });
        $this->multipleChoice = $multiple_choice_answer;


        // matching block check
        $matching_answer = MatchingAnswer::where('exam_id', $examID)->where('user_id', $userID)->get();
        $matching_answer->filter(function ($default) {
            $inputArray = unserialize($default->student_answer);
            return $this->matchingAnswer[$default->matching_id] = $inputArray;
        });
        $this->matching = $matching_answer;

        // short question block check
        $short_question_answer = ShortQuestionAnswer::where('exam_id', $examID)->where('user_id', $userID)->get();
        $short_question_answer->filter(function ($default) {
            // dump($default->student_answer);
            $this->shortQuestionReceiveMark[$default->id] = $default->received_mark;
            return $this->shortQuestionAnswer[$default->short_question_id] = $default->student_answer;
        });
        $this->shortQuestion = $short_question_answer;

        // essay block check
        $essay_answer = EssayAnswer::where('exam_id', $examID)->where('user_id', $userID)->get();
        $essay_answer->filter(function ($default) {
            $this->essayReceiveMark[$default->id] = $default->received_mark;
            return $this->essayAnswer[$default->essay_id] = $default->student_answer;
        });
        $this->essay = $essay_answer;

        $this->questionType = $true_false_answer->isNotEmpty() ? 1 : ($multiple_choice_answer->isNotEmpty() ? 2 : (
            $matching_answer->isNotEmpty() ? 3 : ($short_question_answer->isNotEmpty() ? 4 : 5)
        )); // set default question for teacher

    }
    #[Computed]
    public function role($role)
    {
        if ($role == 'admin') {
            $this->isAdmin = true;
        } elseif ($role == 'teacher') {
            // dd('hello');
            $this->isTeacher = true;
            $this->summaryView = false;
        } elseif ($role == 'student') {
            $this->isStudent = true;
            $this->summaryView = true;
        } else {
            $this->isGuest = true;
        }
    }

    public function examSubmit()
    {
        session(["seconds" => null]);
        session(["mins" => null]);

        $this->isExamPaperOpen = false;

        ExamAnswer::create([
            'user_id' => $this->user_id,
            'exam_id' => $this->id,
            'status' => 1 // exam submit
        ]);

        // $matchingAnswer = MatchingAnswer::first();
        // $answer = $matchingAnswer->student_answer;
        // dd(unserialize($answer));

        // store data to answer table(trueOrfalse,multipleChoice,matching,shortQuestion and Essay)
        $this->answerQuery($this->trueorfalseAnswer, 'App\Models\TrueOrFalseAnswer', 'true_or_false_id');
        $this->answerQuery($this->multipleChoiceAnswer, 'App\Models\MultipleChoiceAnswer', 'multiple_choice_id');
        $this->answerQuery($this->matchingAnswer, 'App\Models\MatchingAnswer', 'matching_id');
        $this->answerQuery($this->shortQuestionAnswer, 'App\Models\ShortQuestionAnswer', 'short_question_id');
        $this->answerQuery($this->essayAnswer, 'App\Models\EssayAnswer', 'essay_id');

        $this->examSubmitted = true;
        $this->examSummary;


        // After a successful submission, set a session flash message
        session()->flash('message', 'Form submitted successfully!');
        // return redirect()->route('courses');

    }
    public function validateCheck($key, $received_mark, $short_question)
    {

        if ($short_question && $received_mark > $short_question->mark) {
            $validator = Validator::make([
                'received_mark' => $received_mark,
                'short_question_mark' => $short_question->mark,
            ], [
                'received_mark' => 'lte:short_question_mark', // Ensure received_mark is less than or equal to short_question_mark
            ], [
                'lte' => ':attribute must be under the given mark.', // Custom error message format
            ]);

            return $validator && $validator->fails() ? $validator->errors() : [];
        }
    }

    public function examMarkUpdate($submitted_user_id)
    {
        // dd($submitted_user_id);
        // $validated = $this->validate([
        //     'shortQuestionReceiveMark.*' => 'required',
        // ]);

        // validation rule for marks (teacher gave marks are less than or equal origin assigned marks)
        $errorMessage = [];

        foreach ($this->shortQuestionReceiveMark as $key => $received_mark) {
            $short_question_answer = ShortQuestionAnswer::find($key);
            $short_question = ShortQuestion::find($short_question_answer->short_question_id);
            $errorMessage[] = $this->validateCheck($key, $received_mark, $short_question);
        }
        // dd($errorMessage);

        foreach ($this->essayReceiveMark as $key => $received_mark) {
            $essay_answer = EssayAnswer::find($key);
            $essay = Essay::find($essay_answer->essay_id);
            $errorMessage[] =  $this->validateCheck($key, $received_mark, $essay);
        }
        // dd($errorMessage);

        $flattenedErrors = collect($errorMessage)->flatMap(function ($messageBag) {
            if ($messageBag instanceof \Illuminate\Support\MessageBag && $messageBag->has('received_mark')) {
                return $messageBag->get('received_mark', []);
            } else {
                return [];
            }
        })->all();

        if ($flattenedErrors) {
            // dd($flattenedErrors);
            return $this->flattenedErrors = $flattenedErrors;
        } else {
            $this->flattenedErrors = [];

            foreach ($this->shortQuestionReceiveMark as $key => $received_mark) {
                $short_question_answer = ShortQuestionAnswer::find($key);
                // dd($short_question_answer);
                if ($short_question_answer) {
                    $short_question_answer->received_mark = $received_mark;
                    $short_question_answer->save();
                }
            }

            foreach ($this->essayReceiveMark as $key => $received_mark) {
                $essay_answer = EssayAnswer::find($key);
                // dd($this->essayReceiveMark);
                if ($essay_answer) {
                    $essay_answer->received_mark = $received_mark;
                    $essay_answer->save();
                }
            }

            // dd($this->shortQuestionReceiveM  ark, $this->essayReceiveMark);

            $examStatusChange = ExamAnswer::where('user_id', $submitted_user_id)->where('exam_id', $this->id)->first();
            if ($examStatusChange) {
                $examStatusChange->status = 2;
                $examStatusChange->save();
            }

            $this->isExamSubmittedStudent = true;
            $this->checkAnsweredPaper = false;
        }
    }
    #[Computed]
    public function examSummary()
    {
        // exam submitted

        $exam = ExamAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->first();
        $this->summaryView = true;
        $this->examStatus = $exam->status;

        if ($exam->status == 2) {

            $this->examSubmittedDate = $exam->created_at;

            $true_false_answer = TrueOrFalseAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->get();
            $multiple_choice_answer = MultipleChoiceAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->get();
            $matching_answer = MatchingAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->get();
            $short_question_answer = ShortQuestionAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->get();
            $essay_answer = EssayAnswer::where('exam_id', $this->id)->where('user_id', $this->user_id)->get();

            $matching_answer->filter(function ($answer) {
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

            $true_false_data = $this->questionsData($true_false_answer, 'App\Models\TrueOrFalse', 'true_or_false_id');
            $multiple_choice_data = $this->questionsData($multiple_choice_answer, 'App\Models\MultipleChoice', 'multiple_choice_id');
            $short_quesiton_data = $this->questionsData($short_question_answer, 'App\Models\ShortQuestion', 'short_question_id');
            $essay_data = $this->questionsData($essay_answer, 'App\Models\Essay', 'essay_id');

            $result = collect([
                'True or False' => $true_false_answer->isNotEmpty() ? collect($true_false_data) : null,
                'Multiple Choice' => $multiple_choice_answer->isNotEmpty() ? collect($multiple_choice_data) : null,
                'Matching' => $matching_answer->isNotEmpty() ? $matching_data : null,
                'Short Question' => $short_question_answer->isNotEmpty() ? collect($short_quesiton_data) : null,
                'Essay' => $essay_answer->isNotEmpty() ? collect($essay_data) : null,
            ])->filter()->all();

            $this->gradeMark = $true_false_data['grade'] + $multiple_choice_data['grade'] + $matching_data['grade'] + $short_quesiton_data['grade'] + $essay_data['grade'];
            $this->baseTotalMark = $true_false_data['total'] + $multiple_choice_data['total'] + $matching_data['total'] + $short_quesiton_data['total'] + $essay_data['total'];
            $this->numberOfQuestion = $true_false_data['origin'] + $multiple_choice_data['origin'] + $matching_data['origin'] + $short_quesiton_data['origin'] + $essay_data['origin'];

            $grade_name = $this->getGrade($this->gradeMark, Grade::all());

            $this->gradeName = $grade_name; // 'D';
            // dump($grade_name);
            return $result;
        }
    }

    public function getGrade($input, $gradesArray)
    {

        foreach ($gradesArray as $grade) {
            $markRange = explode(',', $grade['mark']);
            $lowerBound = intval($markRange[0]);
            $upperBound = intval($markRange[1]);

            if ($input >= $lowerBound && $input <= $upperBound) {
                return $grade['name'];
            }
        }

        // If the input mark doesn't fall into any range, return 'F' or 'Not graded' or any other appropriate indication.
        return 'F';
    }

    public function questionsData($answer, $modelName, $idField)
    {
        // need to fix for short question and essay

        if ($idField == 'short_question_id' || $idField == 'essay_id') {
            $corrected = $answer->filter(function ($answer) {
                return $answer->student_answer != null;
            });

            $grade = $answer->sum(function ($answer) {
                return collect($answer->received_mark)->sum();
            });
        } else {
            $corrected = $answer->filter(function ($answer) use ($modelName, $idField) {
                $primary_answer = $modelName::find($answer->$idField);
                return $answer->student_answer == $primary_answer->answer;
            });
            $grade = $corrected->sum(function ($answer) use ($modelName, $idField) {
                $corrected_question = $modelName::find($answer->$idField);
                return collect($corrected_question->mark)->sum();
            });
        }

        return [
            'correct' => $corrected->count(),
            'origin' => $answer->count(),
            'grade' => $grade,
            'total' => $answer->sum(function ($answer) use ($modelName, $idField) {
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
    public function exams()
    {
        return Exam::findOrFail($this->id);
    }

    public function backToSumittedStudent()
    {
        $this->flattenedErrors = [];
        $this->isExamSubmittedStudent = true;
        $this->checkAnsweredPaper = false;
    }

    public function loadQuestion($question)
    {
        /**
         * 1 => true or false
         * 2 => multiple choice
         * 3 => matching
         * 4 => short question
         * 5 => essay
         */
        $this->questionType = $question;
    }


    public function render()
    {
        return view('livewire.exam-view')->layout("layouts.app");
    }
    public function editExam(){
        $this->isEditExam = true;
        // dd($this->exams->toArray());
        $this->exam_name = $this->exams->exam_name;
        $this->start_date_time = $this->exams->start_date_time;
        $this->end_date_time = $this->exams->end_date_time;
        $this->description = $this->exams->description;
        $this->duration_field = $this->exams->duration;
    }
    public function updateExam(){

        $validated = $this->validate([
            'exam_name' => 'required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'description' => 'required',
            'duration_field' => 'required'
        ]);

        $exam = Exam::find($this->exams->id);

        if($exam){
            $exam->exam_name = $this->exam_name;
            $exam->start_date_time = $this->start_date_time;
            $exam->end_date_time = $this->end_date_time;
            $exam->description = $this->description;
            $exam->duration = $this->duration_field;
            $exam->save();

            $this->toggleModal();
        }
    }
    public function toggleModal()
    {
        $this->isEditExam = !$this->isEditExam;
        $this->resetValidation();
    }
}
