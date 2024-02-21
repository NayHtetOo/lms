<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Forum;
use App\Models\ForumDiscussion;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CourseView extends Component
{
    public Course $currentCourse;
    public $currentCourseSection,$participants;
    public $lessons,$exams,$assignments,$forum;
    public $section_id,$id,$search,$role_id;
    public $isParticipantSearch = false;
    public $alertStatus = false;
    public $alertMessage = "";
    public $currentUser;
    public $discussion,$isForumList;
    public $isSectionTab = true,$isForumTab,$isParticipantTab;
    public $expandedSections = [],$expandedLessons = [] ,$expandedExams = [],$expandedAssignments = [];
    public $currentForum,$isForumReply = false;
    public $replyText,$editReplyText;
    public $discussionList;
    public $isEditReplyText = false;
    public $currentDiscussionId;
    public $isAdmin,$isTeacher,$isStudent,$isGuest;
    public $isEditCourse = false;
    // for course edit
    public $category_type,$course_name,$course_ID,$from_date,$to_date,$description,$course_photo,$visible;
    public $course_categories;

    public function mount($id)
    {
        $this->id = $id;
        $enrollUserId = Enrollment::where('course_id',$id)->pluck('user_id');
        $user_id = auth()->user()->id;


        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $this->id)->first();

        $this->role($enrollment?->role->name);

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
    public function role($role)
    {
        if ($role == 'admin') {
            $this->isAdmin = true;
        } elseif ($role == 'teacher') {
            $this->isTeacher = true;
        } elseif ($role == 'student') {
            $this->isStudent = true;
        } else {
            $this->isGuest = true;
        }
    }

    #[Computed]
    public function course() {
        $course = Course::findOrFail($this->id);
        return $course;
    }

    public function editCourse(){
        $this->isEditCourse = !$this->isEditCourse;
        // dd($this->isEditCourse);

        $this->category_type = $this->currentCourse->course_category_id;
        // dd($this->category_type);
        $this->course_categories = CourseCategory::all();
        // dd($this->course_categories->toArray());

        $this->course_name = $this->currentCourse->course_name;
        $this->course_ID = $this->currentCourse->course_ID;
        $this->from_date = $this->currentCourse->from_date;
        $this->to_date = $this->currentCourse->to_date;
        $this->description = $this->currentCourse->description;
        $this->course_photo = $this->currentCourse->course_photo_path;
        $this->visible = $this->currentCourse->visible;

        // dd($this->currentCourse->toArray());
        // $courseID = $this->currentCourse->id;
        // dd($courseID);
    }
    public function updateCourse(){

        $validated = $this->validate([
            'course_name' => 'required',
            'course_ID' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'visible' => 'required',
            'description' => 'required',
        ]);

        $course = Course::find($this->currentCourse->id);
        if($course){
            $course->course_category_id = $this->category_type;
            $course->course_name = $this->course_name;
            $course->course_ID = $this->course_ID;
            $course->from_date = $this->from_date;
            $course->to_date = $this->to_date;
            $course->visible = $this->visible;
            $course->description = $this->description;
            $course->save();

            $this->toggleModal();
        }
    }

    public function toggleModal()
    {

        $this->isEditCourse = !$this->isEditCourse;
        // dd($this->isEditCourse);
        $this->resetValidation();
    }

    #[Computed]
    public function enrollmentUser() {
        $enrollmentUser = Enrollment::where('user_id', auth()->user()->id)->first();
        return $enrollmentUser;
    }

    #[Computed]
    public function lessons(){
        return Lesson::where('course_id',$this->id)->where('course_section_id',$this->section_id)->get();
    }

    public function sections($id) {
        $this->expandedSections[$id] = ! isset($this->expandedSections[$id]) || !$this->expandedSections[$id];
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
        $this->discussionList = $this->getDiscussionList($forum_id);

    }

    #[Computed]
    public function getDiscussionList($forum_id){
        return $this->discussionList = ForumDiscussion::where('forum_id',$forum_id)->where('course_id',$this->id)->get();
    }

    public function replyForum(){
        $this->isForumReply = !$this->isForumReply;
    }
    public function editReplyCancel(){
        $this->isEditReplyText = false;
        $this->currentDiscussionId = '';
    }
    public function postToForum($forum_id){
        $forum_discuss = ForumDiscussion::create([
            'course_id' => $this->id,
            'forum_id' => $forum_id,
            'user_id' => $this->currentUser->id,
            'reply_text' => $this->replyText,
        ]);

        if($forum_discuss){
            $this->replyText = '';
            $this->isForumReply = !$this->isForumReply;
            $this->discussionList = $this->getDiscussionList($forum_id);
        }

    }
    public function updateToForum($id){
        $forum_discuss = ForumDiscussion::find($id);
        if($forum_discuss){
            $forum_discuss->reply_text = $this->editReplyText;
            $forum_discuss->save();
            $this->isEditReplyText = false;
            $forum_id = $this->currentForum->id;
            $this->currentDiscussionId = '';
            $this->getDiscussionList($forum_id);
        }
    }
    public function editForumDiscussion($id,$status){
        // dd($user_id,$status);
        $forum_id = $this->currentForum->id;
        $forum_discuss = ForumDiscussion::find($id);

        if($status == 1){  // edit reply text

            $this->isEditReplyText = true;
            $this->editReplyText = $forum_discuss->reply_text;
            $this->currentDiscussionId = $forum_discuss->id;

        }else{ // destroy reply text

            if($forum_discuss){
                $forum_discuss->delete();
                $this->getDiscussionList($forum_id);
            }
        }
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
            $this->isParticipantSearch = false;
        }
        if($tab == 2){
            $this->isSectionTab = false;
            $this->isForumTab = true;
            $this->isParticipantTab = false;

            $this->isForumList = true;
            $this->discussion = false;

        }
        if($tab == 3){
            $this->isSectionTab = false;
            $this->isForumTab = false;
            $this->isParticipantTab = true;
            $this->isParticipantSearch = true;
        }

    }
    public function backToForum(){
        // dd('hello');
        $this->discussion = false;
        $this->isForumList = true;
    }
}
