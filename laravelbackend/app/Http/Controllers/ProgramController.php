<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function addProgram(Request $request)
    {
        $validatedData = $request->validate([
            'programName' => 'required',
            'programDescription' => 'required',
            'programOrganizer' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'venue' => 'required'
        ]);

        $program = Program::create($validatedData);

        return response("Program added successfully", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function deleteProgram(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'program' => 'required|exists:programs,programName', // Ensure the program exists
        ]);

        // Find and delete the program
        $program = Program::where('programName', $validatedData['program'])->first();

        if ($program) {
            $program->delete();
            return response("Program deleted successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error deleting program: Program not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateProgram(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'initialprogram_id' => 'required|exists:programs,programName',
            'programName' => 'required',
            'programDescription' => 'required',
            'programOrganizer' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        // Find the program by initial name and update details
        $program = Program::where('programName', $validatedData['initialprogram_id'])->first();

        if ($program) {
            $program->update([
                'programName' => $validatedData['programName'],
                'programDescription' => $validatedData['programDescription'],
                'programOrganizer' => $validatedData['programOrganizer'],
                'startDate' => $validatedData['startDate'],
                'endDate' => $validatedData['endDate'],
            ]);

            return response("Program updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Program not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchProgramNames()
    {
        // Fetching program names from the database
        $programs = Program::pluck('programName'); // Fetches only the 'programName' column

        return response()->json($programs);
    }
    public function fetchProgramDetails(Request $request)
    {
        // Validate the courseId (programName)
        $validatedData = $request->validate(['courseId' => 'required|exists:programs,programName']);

        $program = Program::where('programName', $validatedData['courseId'])->first();

        if ($program) {
            $details = "{$program->programOrganizer},{$program->programDescription},{$program->startDate},{$program->endDate},{$program->venue}";
            return response($details, 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: Program not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchAllPrograms()
    {
        $programs = Program::all();

        return response()->json(['AllPrograms' => $programs]);
    }
}
