<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Livewire\Attributes\Computed;
use Livewire\Component;

class LessonView extends Component
{
    public Lesson $lesson;
    public $courseID;
    public $isAdmin,$isTeacher,$isStudent,$isGuest;
    public $isEditLesson;
    public $lesson_name,$content;

    public function mount($id)
    {
        $this->lesson = Lesson::findOrFail($id);
        $this->courseID = Course::findOrFail($this->lesson->course_id)->course_ID;
        $user_id = auth()->user()->id;
        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $this->lesson->course_id)->first();
        $this->role($enrollment->role->name);
    }

    public function render()
    {
        return view('livewire.lesson-view')->layout("layouts.app");
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
    public function editLesson(){
        $this->isEditLesson = true;
        // dd($this->lesson->toArray());
        $this->lesson_name = $this->lesson->lesson_name;
        $this->content = strip_tags($this->lesson->content);
    }
    public function updateLesson(){

        $validated = $this->validate([
            'lesson_name' => 'required',
            'content' => 'required'
        ]);

        $lesson = Lesson::find($this->lesson->id);

        if($lesson){
            $lesson->lesson_name = $this->lesson_name;
            $lesson->content = $this->content;
            $lesson->save();

            $this->toggleModal();
        }
    }
    public function toggleModal()
    {
        $this->isEditLesson = !$this->isEditLesson;
        $this->resetValidation();
    }

}
