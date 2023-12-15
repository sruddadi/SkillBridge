<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'first_name' => $validatedData['firstname'],
            'last_name' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'role' => $validatedData['role']
        ]);

        return response('User registered successfully', 201, ['Content-Type' => 'text/plain']);
    }
    public function deleteUser(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email', // Ensure the user exists
        ]);

        // Find and delete the user
        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            $user->delete();
            return response("User deleted successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error deleting user: User not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateUser(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'initialuser_id' => 'required|email|exists:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->initialuser_id . ',email',
            'password' => 'required',
            'role' => 'required',
        ]);

        // Find the user by initial email and update details
        $user = User::where('email', $validatedData['initialuser_id'])->first();

        if ($user) {
            $user->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'], // Hashing the password
                'role' => $validatedData['role']
            ]);

            return response("User updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: User not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchInstructors()
    {
        $instructors = User::where('role', 'Instructor')
            ->pluck('first_name'); // Fetch only the first_name column

        return response()->json($instructors);
    }
    public function fetchInstructorLastNames()
    {
        // Fetching only the last names of users with the 'Instructor' role
        $instructors = User::where('role', 'Instructor')
            ->pluck('last_name'); // Fetches only the 'last_name' column

        return response()->json($instructors);
    }
    public function fetchUserCounts()
    {
        // Fetching counts for each role
        $adminCount = User::where('role', 'Admin')->count();
        $studentCount = User::where('role', 'Student')->count();
        $instructorCount = User::where('role', 'Instructor')->count();
        $pcCount = User::where('role', 'Program Coordinator')->count();
        $qaCount = User::where('role', 'QA Officer')->count();

        // Concatenate counts into a string
        $counts = "$adminCount,$studentCount,$instructorCount,$pcCount,$qaCount";

        return response($counts, 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchUserDetails(Request $request)
    {
        // Validate the email
        $validatedData = $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            $details = "{$user->first_name},{$user->last_name},{$user->role}";
            return response($details, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Login Failed", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchUserRole(Request $request)
    {
        // Validate the email
        $validatedData = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            return response($user->role, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Login Failed", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchUserName(Request $request)
    {
        // Validate the email
        $validatedData = $request->validate(['email' => 'required|email']);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            $fullName = $user->first_name . ' ' . $user->last_name;
            return response($fullName, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Login Failed", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateUserDetails(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user) {
            $user->first_name = $validatedData['firstname'];
            $user->last_name = $validatedData['lastname'];
            $user->password = $validatedData['password']; // Hashing the password
            $user->save();

            return response("Login Successful | Role: " . $user->role, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: User not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchAllUsers()
    {
        $users = User::all();

        return response()->json(['AllUsers' => $users]);
    }
}
