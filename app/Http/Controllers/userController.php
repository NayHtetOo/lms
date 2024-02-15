<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;

class userController extends Controller
{
    public function index () {
        $courses = Course::where('visible', 1)->orderBy('created_at', 'desc')->paginate(4);
        return view('welcome', ["courses" => $courses]);
    }

    public function submit (Request $request) {
        ExamAnswer::create([
            'user_id' => $request->user_id,
            'exam_id' => $request->exam_id,
            'status' => 1 // exam submit
        ]);

        return response()->json([
            'message' => "Exam time's out."
        ]);
    }
}
