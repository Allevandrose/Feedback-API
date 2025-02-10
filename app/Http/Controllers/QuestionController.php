<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['user', 'answers'])->get();
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'created_by' => 'required|exists:users,id',
            'answers' => 'required|array', // Array of answers
            'answers.*.answer_text' => 'required|string', // Validate each answer
        ]);

        // Create the question
        $question = Question::create([
            'question_text' => $request->question_text,
            'created_by' => $request->created_by,
        ]);

        // Create multiple answers for the question
        foreach ($request->answers as $answerData) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answerData['answer_text'],
            ]);
        }

        return response()->json(['message' => 'Question and answers created successfully', 'question' => $question], 201);
    }

    public function show($id)
    {
        $question = Question::with(['user', 'answers'])->find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        return response()->json($question);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $request->validate(['question_text' => 'required|string']);

        $question->update($request->all());
        return response()->json(['message' => 'Question updated successfully', 'question' => $question]);
    }

    public function destroy($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $question->delete();
        return response()->json(['message' => 'Question deleted successfully']);
    }
}