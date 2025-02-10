<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionAnswer;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with('student')->get();
        return response()->json($submissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'answers' => 'required|array',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        $submission = Submission::create(['student_id' => $request->student_id]);

        foreach ($request->answers as $answer) {
            SubmissionAnswer::create([
                'submission_id' => $submission->id,
                'answer_id' => $answer['answer_id'],
            ]);
        }

        return response()->json(['message' => 'Submission created successfully', 'submission' => $submission], 201);
    }

    public function show($id)
    {
        $submission = Submission::with(['student', 'submissionAnswers.answer'])->find($id);

        if (!$submission) {
            return response()->json(['error' => 'Submission not found'], 404);
        }

        return response()->json($submission);
    }
}