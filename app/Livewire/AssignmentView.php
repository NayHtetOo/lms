<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AssignmentView extends Component
{
    public $id;

    public function mount($id){
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
}
