<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Forum;
use App\Models\Lesson;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CourseView extends Component
{
    public Course $currentCourse;

    public $currentCourseSection;
    public $participants;

    public $lessons;
    public $exams;
    public $assignments;
    public $forum;
    public $section_id;
    public $id;
    public $search;
    public $isParticipantSearch = false;
    public $role_id;
    public $alertMessage = "";
    public $alertStatus = false;
    public $currentUser;
    public $discussion,$isForumList;
    public $isSectionTab = true,$isForumTab,$isParticipantTab,$isSettingTab;
    public $expandedSections = [],$expandedLessons = [] ,$expandedExams = [],$expandedAssignments = [];
    public $currentForum;

    public function mount($id)
    {
        $this->id = $id;
        $enrollUserId = Enrollment::where('course_id',$id)->pluck('user_id');

        // role check
        // $enrollUsers = Enrollment::where('course_id',$id)->get();
        // $auth_user = $enrollUsers->filter(function($user){
        //     return $user->user_id == auth()->user()->id;
        // });
        // $this->role_id = $auth_user->first()->role_id;
        // dump($this->role_id);

        $authorized = $enrollUserId->contains(auth()->user()->id);

        if(! $authorized){
            // dd('Unauthorized');
            return redirect()->route('courses');
        }
    }

    #[Computed]
    public function enrollmentUser() {
        $enrollmentUser = Enrollment::where('user_id', auth()->user()->id)->first();
        return $enrollmentUser;
    }

    // #[Computed]
    // public function currentCourse(){
    //     // return Course::findOrFail($this->id);
    // }

    // #[Computed]
    // public function participants(){

    // }


    #[Computed]
    public function lessons(){
        return Lesson::where('course_id',$this->id)->where('course_section_id',$this->section_id)->get();
    }

    public function sections($id) {
        $this->expandedSections[$id] = ! isset($this->expandedSections[$id]) || !$this->expandedSections[$id];
        // dd('Clicked section');
        $lessons = CourseSection::with("lessons")->where('id', $id)->get()->toArray();
        $exams = CourseSection::with("exams")->where('id', $id)->get()->toArray();
        $assignments = CourseSection::with("assignments")->where('id', $id)->get()->toArray();

        if ($lessons[0]["lessons"] == [] && $exams[0]["exams"] == [] && $assignments[0]["assignments"] == []) {
            $this->alertStatus = true;
            $this->alertMessage = "This sections isn't added.";
        }
    }
    public function lessonsExpand($id) {
        $this->expandedLessons[$id] = ! isset($this->expandedLessons[$id]) || !$this->expandedLessons[$id];
    }

    public function examsExpand($id) {
        $this->expandedExams[$id] = ! isset($this->expandedExams[$id]) || !$this->expandedExams[$id];
    }
    public function assignmentsExpand($id){
        $this->expandedAssignments[$id] = ! isset($this->expandedAssignments[$id]) || !$this->expandedAssignments[$id];
    }

    public function closeAlertMessage() {
        $this->alertStatus = false;
    }

    public function render()
    {
        // authorized
        $this->currentCourse = Course::findOrFail($this->id);

        $this->section_id = $this->currentCourse->id;
        $this->currentCourseSection = CourseSection::where('course_id',$this->section_id)->get();

        if($this->search){
            $this->isParticipantSearch = true;
            $participants = Enrollment::where('course_id',$this->id)->get();
            $participant_name = $this->search;

            $this->participants = $participants->filter(function($participant) use ($participant_name){
                // dump($participant->user->name);
                return stripos($participant->user->name,$participant_name) !== false;
            });
        }else{
            $this->participants = Enrollment::where('course_id',$this->id)->get();
        }

        $this->forum = Forum::where('course_id',$this->id)->get();
        $this->lessons = Lesson::where('course_id',$this->id)->get();
        $this->exams = Exam::where('course_id',$this->id)->get();
        $this->assignments = Assignment::where('course_id',$this->id)->get();

        // dump($this->participants);
        return view('livewire.course-view');
    }

    public function forumDiscussion($forum_id){
        // dd($forum_id);
        $this->isForumList = false;
        $this->discussion = true;

        $user_id = auth()->user()->id;
        $this->currentUser = User::find($user_id);

        $this->currentForum = Forum::find($forum_id);

    }
    public function switchTab($tab){
        /**
         * 1 => section tab
         * 2 => forum tab
         * 3 => participant tab
         * 4 => setting tab
         */
        if($tab == 1){
            $this->isSectionTab = true;
            $this->isForumTab = false;
            $this->isParticipantTab = false;
            $this->isSettingTab = false;
            $this->isParticipantSearch = false;
        }
        if($tab == 2){
            $this->isSectionTab = false;
            $this->isForumTab = true;
            $this->isParticipantTab = false;
            $this->isSettingTab = false;

            $this->isForumList = true;
            $this->discussion = false;

        }
        if($tab == 3){
            $this->isSectionTab = false;
            $this->isForumTab = false;
            $this->isParticipantTab = true;
            $this->isSettingTab = false;
            $this->isParticipantSearch = true;
        }
        if($tab == 4){
            $this->isSectionTab = false;
            $this->isForumTab = false;
            $this->isParticipantTab = false;
            $this->isSettingTab = true;
        }

    }
    public function backToForum(){
        // dd('hello');
        $this->discussion = false;
        $this->isForumList = true;
    }
}
