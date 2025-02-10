<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::with('question')->get();
        return response()->json($answers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string',
        ]);

        $answer = Answer::create($request->all());
        return response()->json(['message' => 'Answer created successfully', 'answer' => $answer], 201);
    }

    public function show($id)
    {
        $answer = Answer::with('question')->find($id);

        if (!$answer) {
            return response()->json(['error' => 'Answer not found'], 404);
        }

        return response()->json($answer);
    }

    public function destroy($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            return response()->json(['error' => 'Answer not found'], 404);
        }

        $answer->delete();
        return response()->json(['message' => 'Answer deleted successfully']);
    }
}