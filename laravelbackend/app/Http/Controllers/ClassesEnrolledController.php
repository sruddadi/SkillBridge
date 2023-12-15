<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassesEnrolled;

class ClassesEnrolledController extends Controller
{
    public function addCourse(Request $request)
    {
        $validatedData = $request->validate([
            'course_name' => 'required',
            'course_id' => 'required',
            'instructor_name' => 'required',
            'course_period' => 'required',
        ]);

        $course = ClassesEnrolled::create([
            'courseName' => $validatedData['course_name'],
            'courseId' => $validatedData['course_id'],
            'professorName' => $validatedData['instructor_name'],
            'period' => $validatedData['course_period'],
            'status' => 'no',
        ]);

        return response("Course added successfully", 200)
            ->header('Content-Type', 'text/plain');
    }

    public function updateExam(Request $request)
    {
        $validatedData = $request->validate([
            'exam' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'quizlink' => 'required',
            'resources' => 'required',
            'courseId' => 'required'
        ]);

        $class = ClassesEnrolled::where('courseId', $validatedData['courseId'])
            ->where('status', 'yes')
            ->first();

        if ($class) {
            $class->update([
                'exam' => $validatedData['exam'],
                'startTime' => $validatedData['startTime'],
                'endTime' => $validatedData['endTime'],
                'quizlink' => $validatedData['quizlink'],
                'resources' => $validatedData['resources']
            ]);

            return response("Exam added successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Class not found or inactive", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function deleteCourse(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'course' => 'required|exists:classesEnrolled,courseId', // Ensure the course exists
        ]);

        // Find and delete the course
        $course = ClassesEnrolled::where('courseId', $validatedData['course'])->first();

        if ($course) {
            $course->delete();
            return response("Course deleted successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error deleting course: Course not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateCourse(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'initialcourse_id' => 'required|exists:classesEnrolled,courseId',
            'course_id' => 'required',
            'course_name' => 'required',
            'instructor_name' => 'required',
            'course_period' => 'required',
        ]);

        // Find the course by initial ID and update details
        $course = ClassesEnrolled::where('courseId', $validatedData['initialcourse_id'])->first();

        if ($course) {
            $course->update([
                'courseName' => $validatedData['course_name'],
                'courseId' => $validatedData['course_id'],
                'professorName' => $validatedData['instructor_name'],
                'period' => $validatedData['course_period']
            ]);

            return response("Course updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Course not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateGradeAndResources(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'intialEmail_id' => 'required|email|exists:users,email',
            'grade' => 'required',
            'courseId' => 'required|exists:classesEnrolled,courseId',
            'resources' => 'required',
        ]);

        // Find the class enrollment entry and update details
        $enrollment = ClassesEnrolled::where('email', $validatedData['intialEmail_id'])
            ->where('courseId', $validatedData['courseId'])
            ->first();

        if ($enrollment) {
            $enrollment->update([
                'resources' => $validatedData['resources'],
                'grade' => $validatedData['grade']
            ]);

            return response("Grade updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Enrollment not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateExamDetails(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'intialEmail_id' => 'required|email|exists:users,email',
            'startTime' => 'required',
            'endTime' => 'required',
            'quizlink' => 'required',
            'exam' => 'required',
        ]);

        // Find the class enrollment entry and update details
        $enrollment = ClassesEnrolled::where('email', $validatedData['intialEmail_id'])->first();

        if ($enrollment) {
            $enrollment->update([
                'startTime' => $validatedData['startTime'],
                'endTime' => $validatedData['endTime'],
                'quizlink' => $validatedData['quizlink'],
                'exam' => $validatedData['exam']
            ]);

            return response("Exam updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Enrollment not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function enrollCourse(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'course_id' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'courseName' => 'required',
            'instructorName' => 'required',
            'coursePeriod' => 'required',
        ]);

        // Create a new enrollment
        $enrollment = ClassesEnrolled::create([
            'courseId' => $validatedData['course_id'],
            'email' => $validatedData['email'],
            'studentName' => $validatedData['name'],
            'courseName' => $validatedData['courseName'],
            'professorName' => $validatedData['instructorName'],
            'period' => $validatedData['coursePeriod'],
            'status' => 'yes',
            'resources' => 'TBA',
            'grade' => 'TBA'
        ]);

        return response("Course enrolled successfully", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchCourseIds()
    {
        // Fetching courseId where status is 'no'
        $courses = ClassesEnrolled::where('status', 'no')
            ->pluck('courseId'); // Fetches only the 'courseId' column

        return response()->json($courses);
    }
    public function fetchCourseDetailsEmail()
    {
        $courses = ClassesEnrolled::where('status', 'yes')
            ->select('courseId', 'professorName')
            ->get();

        return response()->json($courses);
    }
    public function fetchCourseDetails(Request $request)
    {
        // Validate the courseId
        $validatedData = $request->validate([
            'courseId' => 'required|exists:classesEnrolled,courseId',
        ]);

        $course = ClassesEnrolled::where('courseId', $validatedData['courseId'])->first();

        if ($course) {
            // Concatenate course details into a string
            $details = "{$course->courseName},{$course->professorName},{$course->period}";
            return response($details, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Course not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchCourseData()
    {
        $courses = ClassesEnrolled::selectRaw('courseName, COUNT(email) AS students_count')
            ->where('status', 'yes')
            ->groupBy('courseName')
            ->get();

        $data = [
            'labels' => $courses->pluck('courseName'),
            'datasets' => [
                [
                    'data' => $courses->pluck('students_count')
                ]
            ]
        ];

        return response()->json($data);
    }
    public function fetchEnrollments(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate(['email' => 'required|email']);

        $classes = ClassesEnrolled::where('email', $validatedData['email'])->get();

        if ($classes->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'classes' => $classes
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No matching records found'
            ]);
        }
    }
    public function fetchAllCourses()
    {
        $courses = ClassesEnrolled::all()->map(function ($course) {
            return [
                'course_name' => $course->courseName,
                'course_id' => $course->courseId,
                'instructor_name' => $course->professorName,
                'course_period' => $course->period,
                'status' => $course->status
            ];
        });

        return response()->json(['AllCourses' => $courses]);
    }
    public function fetchAllClassEnrollments()
    {
        $enrollments = ClassesEnrolled::all();

        return response()->json(['studentResults' => $enrollments]);
    }
}
