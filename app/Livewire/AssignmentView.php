<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AssignmentView extends Component
{
    public $id;
    public $assignment_name,$description;
    public $isEditAssignment;
    public $isAdmin,$isTeacher,$isStudent,$isGuest;


    public function mount($id){
        $user_id = auth()->user()->id;

        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $this->assignment->course_id)->first();

        // dd($enrollment);
        $this->role($enrollment->role->name);
        return $this->id = $id;
    }

    #[Computed]
    public function assignment(){
        return Assignment::findOrFail($this->id);
    }
    #[Computed]
    public function courseID(){
        return Course::findOrFail($this->assignment->course_id)->course_ID;
    }

    public function render()
    {
        return view('livewire.assignment-view')->layout("layouts.app");
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
    public function editAssignment(){
        $this->isEditAssignment = true;
        // dd($this->lesson->toArray());
        $this->assignment_name = $this->assignment->assignment_name;
        $this->description = strip_tags($this->assignment->description);
    }
    public function updateAssignment(){

        $validated = $this->validate([
            'assignment_name' => 'required',
            'description' => 'required'
        ]);

        $assignment = Assignment::find($this->assignment->id);

        if($assignment){
            $assignment->assignment_name = $this->assignment_name;
            $assignment->description = $this->description;
            $assignment->save();

            $this->toggleModal();
        }
    }
    public function toggleModal()
    {
        $this->isEditAssignment = !$this->isEditAssignment;
        $this->resetValidation();
    }
}
