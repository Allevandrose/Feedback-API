<?php

// SubmissionAnswer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionAnswer extends Model
{
    protected $fillable = ['submission_id', 'question_id', 'answer_id'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}