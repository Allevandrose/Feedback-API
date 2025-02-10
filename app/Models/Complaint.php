<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'student_id', 
        'message', 
        'status', 
        'admin_response', 
        'responded_by'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}