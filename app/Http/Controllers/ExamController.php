<?php

namespace App\Http\Controllers;

use App\Models\Exam;

class ExamController extends Controller
{
    public function show()
    {
        $exam = Exam::first();

        return view('participant.exam', compact('exam'));
    }
}