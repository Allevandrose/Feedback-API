<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionAnswer;
use App\Models\Answer;
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
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.answer_id' => 'required|exists:answers,id',
        ]);

        $submission = Submission::create(['student_id' => $request->student_id]);

        foreach ($request->answers as $answer) {
            $answerModel = Answer::findOrFail($answer['answer_id']);
            
            if ($answerModel->question_id != $answer['question_id']) {
                return response()->json([
                    'error' => 'Answer does not belong to the specified question'
                ], 422);
            }

            SubmissionAnswer::create([
                'submission_id' => $submission->id,
                'question_id' => $answer['question_id'],
                'answer_id' => $answer['answer_id'],
            ]);
        }

        return response()->json(['message' => 'Submission created', 'submission' => $submission], 201);
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
