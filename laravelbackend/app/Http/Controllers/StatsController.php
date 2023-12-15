<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClassesEnrolled;
use App\Models\ProgramEnroll;
use App\Models\Program;
use App\Models\QAUpdate;

class StatsController extends Controller
{
    public function fetchCounts()
    {
        $userCount = User::count();
        $courseCount = ClassesEnrolled::where('status', 'no')->count();
        $programCount = Program::count();
        $policyCount = QAUpdate::count();

        // Concatenate counts into a string
        $counts = "$userCount,$courseCount,$programCount,$policyCount";

        return response($counts, 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchInstructors(Request $request)
    {
        $validatedData = $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $validatedData['email'])->first();
        $name = $user ? "{$user->first_name} {$user->last_name}" : "Failed";

        $userCount = User::where('role', 'Student')->count();
        $courseCount = ClassesEnrolled::where('status', 'yes')
            ->where('professorName', $name)
            ->distinct('email')
            ->count();
        $programCount = ClassesEnrolled::whereNotNull('quizlink')->count();
        $someCount = ClassesEnrolled::where('status', 'no')
            ->where('professorName', $name)
            ->count();

        $counts = "$userCount,$courseCount,$programCount,$someCount";

        return response($counts, 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchPCCounts()
    {
        $userCount = User::where('role', 'Student')->count();
        $courseCount = Program::count();
        $programCount = ProgramEnroll::count();

        $counts = "$userCount,$courseCount,$programCount";

        return response($counts, 200)
            ->header('Content-Type', 'text/plain');
    }
}
