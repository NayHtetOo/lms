<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\AssignmentDraft;
use App\Models\AssignmentFinal;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AssignmentView extends Component
{
    use WithFileUploads;
    public $id;
    public $assignment_name, $description;
    public $isEditAssignment;
    public $isAdmin, $isTeacher, $isStudent, $isGuest;
    public $assignmentFile;
    public $assignmentTitle;
    public $assignmentTitleStatus = false;
    public $assignmentTitleValidation;
    public $assignmentSave = [];
    public $teacherMarkModalStatus = false;
    public $submittedStudent;
    public $receivedMark;

    public function mount($id)
    {
        $user_id = auth()->user()->id;

        $enrollment = Enrollment::where('user_id', $user_id)->where('course_id', $this->assignment->course_id)->first();

        // dd($enrollment);
        $this->role($enrollment->role->name);
        return $this->id = $id;
    }


    #[Computed]
    public function assignment()
    {
        if ($this->id) {
            return Assignment::findOrFail($this->id);
        }
    }

    #[Computed]
    public function course()
    {
        $course = Course::findOrFail($this->assignment->course_id);
        return $course;
    }

    #[Computed]
    public function courseID()
    {
        return Course::findOrFail($this->assignment->course_id)->course_ID;
    }

    #[Computed]
    public function studentAssignment()
    {
        $assignment = AssignmentFinal::where('user_id', auth()->user()->id)
            ->where('course_section_id', $this->assignment()->course_section_id)
            ->where('assignment_id', $this->id)
            ->first();
        return $assignment;
    }

    #[Computed]
    public function allAssignments()
    {
        $assign = $this->assignment();
        $finalAssignment = AssignmentFinal::where('assignment_id', $this->id)
                        ->where('course_id', $assign->course_id)
                        ->where('course_section_id', $assign->course_section_id)
                        ->get();
        return $finalAssignment;
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
    public function editAssignment()
    {
        $this->isEditAssignment = true;
        // dd($this->lesson->toArray());
        $this->assignment_name = $this->assignment->assignment_name;
        $this->description = strip_tags($this->assignment->description);
    }
    public function updateAssignment()
    {

        $validated = $this->validate([
            'assignment_name' => 'required',
            'description' => 'required'
        ]);

        $assignment = Assignment::find($this->assignment->id);

        if ($assignment) {
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

    #[Computed]
    public function assignmentDraft()
    {
        $assignment = Assignment::find($this->assignment()->id);
        $draft = AssignmentDraft::where('course_section_id', $assignment->course_section_id)
            ->where('user_id', auth()->user()->id)
            ->first();

        return $draft;
    }

    public function saveDraft()
    {
        $this->validate([
            'assignmentFile' => 'required|mimes:pdf|max:5120'
        ]);

        $assignment = Assignment::find($this->assignment()->id);
        $courseSectionId = $assignment->course_section_id;
        $userId = auth()->user()->id;

        $assignmentDraft = AssignmentDraft::where('course_section_id', $courseSectionId)
            ->where('user_id', $userId)
            ->first();


        if ($this->assignmentFile) {
            $fileName = $this->assignmentFile->hashName();
            if (isset($assignmentDraft->assignment_file_path)) {
                AssignmentDraft::where('course_section_id', $courseSectionId)
                    ->where('user_id', $userId)
                    ->update([
                        'course_section_id' => $courseSectionId,
                        'user_id' => $userId,
                        'assignment_file_path' => 'assignmentFilePath/' . $fileName,
                    ]);
                if (Storage::exists('public/' . $assignmentDraft->assignment_file_path)) {
                    Storage::delete('public/' . $assignmentDraft->assignment_file_path);
                }
            } else {
                AssignmentDraft::create([
                    'course_section_id' => $courseSectionId,
                    'user_id' => $userId,
                    'assignment_file_path' => 'assignmentFilePath/' . $fileName,
                ]);
            }
            $this->assignmentTitleStatus = true;
            $this->assignmentFile->storeAs('public/assignmentFilePath', $fileName);
            $this->reset('assignmentFile');
        }
    }

    public function updateTitle()
    {
        $assignment = Assignment::find($this->assignment()->id);
        $courseSectionId = $assignment->course_section_id;
        $userId = auth()->user()->id;
        $assignmentDraft = AssignmentDraft::where('course_section_id', $courseSectionId)
            ->where('user_id', $userId)
            ->get();

        if ($this->assignmentTitle) {
            AssignmentDraft::where('course_section_id', $courseSectionId)
                ->where('user_id', $userId)
                ->update([
                    'assignment_title' => $this->assignmentTitle
                ]);
            $this->assignmentTitleStatus = false;
        } else {
            session()->flash('titleMessage', "You must's fill the assignment title");
        }
    }

    public function closeTitle()
    {
        $this->assignmentTitleStatus = false;
    }

    public function deleteAttachment()
    {

        if (Storage::exists('public/' . $this->assignmentDraft()->assignment_file_path)) {
            Storage::delete('public/' . $this->assignmentDraft()->assignment_file_path);
        }

        $assignment = Assignment::find($this->assignment()->id);
        $courseSectionId = $assignment->course_section_id;
        $userId = auth()->user()->id;

        AssignmentDraft::where('course_section_id', $courseSectionId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function finalSave()
    {
        $assignment = Assignment::find($this->assignment()->id);
        $courseSectionId = $assignment->course_section_id;
        $userId = auth()->user()->id;
        $finalAssignment = AssignmentFinal::where('assignment_id', $assignment->id)->where('user_id', $userId)->where('course_section_id', $courseSectionId)->exists();
        // dd($finalAssignment);
        $assignmentDraft = AssignmentDraft::where('course_section_id', $courseSectionId)
            ->where('user_id', $userId)
            ->first();

        if (Storage::exists('public/' . $assignment->assignment_file_path)) {
            Storage::delete('public/' . $assignment->assignment_file_path);
        }

        if ($finalAssignment) {
            AssignmentFinal::where('course_section_id', $courseSectionId)->where('user_id', $userId)->update([
                'course_id' => $assignment->course_id,
                'course_section_id' => $assignment->course_section_id,
                'user_id' => $userId,
                'assignment_id' => $assignment->id,
                'assignment_file_path' => $assignmentDraft->assignment_file_path,
                'assignment_title' => $assignmentDraft->assignment_title,
                'status' => 1, // process status
            ]);
        } else {
            AssignmentFinal::create([
                'course_id' => $assignment->course_id,
                'course_section_id' => $assignment->course_section_id,
                'user_id' => $userId,
                'assignment_id' => $assignment->id,
                'assignment_file_path' => $assignmentDraft->assignment_file_path,
                'assignment_title' => $assignmentDraft->assignment_title,
                'status' => 1, // process status
            ]);

        }

        AssignmentDraft::where('course_section_id', $courseSectionId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function markTeacher($assignmentId) {
        $this->teacherMarkModalStatus = true;
        $assignmentFinal = AssignmentFinal::where('id', $assignmentId)->first();

        if ($assignmentFinal->received_mark) {
            $this->receivedMark = $assignmentFinal->received_mark;
        } else {
            $this->receivedMark = null;
        }

        $this->submittedStudent = $assignmentFinal;
    }

    public function closeAssignTeacher() {
        $this->teacherMarkModalStatus = false;
    }

    public function updateMark($assignmentId) {
        $this->validate([
            'receivedMark' => 'required|max:3'
        ], [
            'receivedMark' => 'Given mark must be between 1 to 100'
        ]);
        AssignmentFinal::where('id', $assignmentId)->update([
            'received_mark' => $this->receivedMark,
            'status' => 2,
        ]);
        $this->reset('receivedMark');
        $this->teacherMarkModalStatus = false;
    }

      public function render()
    {
        return view('livewire.assignment-view')->layout("layouts.app");
    }
}
