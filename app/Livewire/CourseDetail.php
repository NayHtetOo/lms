<?php

namespace App\Livewire;

use Livewire\Component;

class CourseDetail extends Component
{
    public $courseId;
    public function mount($id = null) {
        $this->courseId = $id;
        dd($this->courseId);
    }

    public function render()
    {
        return view('livewire.course-detail')->layout('layouts.app');
    }
}
