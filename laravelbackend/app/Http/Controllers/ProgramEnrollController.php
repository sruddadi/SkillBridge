<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramEnroll; // Replace with your actual model name

class ProgramEnrollController extends Controller
{
    public function enrollProgram(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'course_id' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'courseName' => 'required',
            'instructorName' => 'required',
            'coursePeriod' => 'required',
            's' => 'required', // Better to rename these to more descriptive names
            'ss' => 'required',
        ]);

        // Create a new program enrollment
        $programEnrollment = ProgramEnroll::create([
            'sname' => $validatedData['name'],
            'semail' => $validatedData['email'],
            'programName' => $validatedData['course_id'],
            'pOrganizer' => $validatedData['courseName'],
            'pDescription' => $validatedData['instructorName'],
            'startDate' => $validatedData['coursePeriod'],
            'endDate' => $validatedData['s'],
            'venue' => $validatedData['ss']
        ]);

        return response("Program enrolled successfully", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchAllProgramEnrollments()
    {
        $enrollments = ProgramEnroll::all();

        return response()->json(['AllPrograms' => $enrollments]);
    }
}
