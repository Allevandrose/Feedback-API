<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // Student routes
    public function index(Request $request)
    {
        $complaints = $request->user()->complaints;
        return response()->json($complaints);
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        
        $complaint = Complaint::create([
            'student_id' => $request->user()->id,
            'message' => $request->message
        ]);
        
        return response()->json($complaint, 201);
    }

    // Admin routes
    public function indexAll()
    {
        $complaints = Complaint::with(['student', 'responder'])->get();
        return response()->json($complaints);
    }

    public function respond(Request $request, Complaint $complaint)
    {
        $request->validate(['admin_response' => 'required|string']);
        
        $complaint->update([
            'admin_response' => $request->admin_response,
            'responded_by' => $request->user()->id,
            'status' => 'resolved'
        ]);
        
        return response()->json($complaint);
    }
}