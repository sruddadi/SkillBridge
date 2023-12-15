<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassesEnrolled extends Model
{
    protected $table = 'classesEnrolled';
    protected $fillable = ['studentName', 'email', 'courseName', 'courseId', 'professorName', 'exam', 'startTime', 'endTime', 'quizlink', 'resources', 'grade', 'period', 'status'];

    public $timestamps = false; // Add this line if your table doesn't have created_at and updated_at columns
}
