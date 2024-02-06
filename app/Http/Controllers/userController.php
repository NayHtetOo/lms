<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class userController extends Controller
{

    public function index () {
        $courses = Course::paginate(4);
        return view('welcome', ["courses" => $courses]);
    }
}
