<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if ($user && $validatedData['password'] == $user->password) {
            // Concatenate the role with the message
            $role = $user->role; // Assuming 'role' is a column in your users table
            return response("Login Successful | Role: $role", 200)
                ->header('Content-Type', 'text/plain');
        }

        return response("Login Failed", 401)
            ->header('Content-Type', 'text/plain');
    }
}
