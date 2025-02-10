<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['student_id'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}