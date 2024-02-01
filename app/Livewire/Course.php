<?php

namespace App\Livewire;

use App\Models\Course as ModelsCourse;
use App\Models\Enrollment;
use App\Models\Role;
use LDAP\Result;
use Livewire\Component;

class Course extends Component
{

    public function render()
    {
        // dd(auth()->user()->id);
        $enrollment = Enrollment::where('user_id', auth()->user()->id)->pluck('course_id');

        return view('livewire.course',[
            'courses' => ModelsCourse::whereIn('id',$enrollment)->get()
        ]);
    }
}
