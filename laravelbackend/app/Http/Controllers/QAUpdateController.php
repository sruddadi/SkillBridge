<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QAUpdate;

class QAUpdateController extends Controller
{
    public function addQA(Request $request)
    {
        $validatedData = $request->validate([
            'policyId' => 'required',
            'qaPolicies' => 'required',
            'year' => 'required|integer'
        ]);

        $qaUpdate = QAUpdate::create($validatedData);

        return response("QA added successfully", 200)
            ->header('Content-Type', 'text/plain');
    }
    public function deleteQA(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'policyId' => 'required|exists:qAUpdates,policyId', // Ensure the QA entry exists
        ]);

        // Find and delete the QA entry
        $qaUpdate = QAUpdate::where('policyId', $validatedData['policyId'])->first();

        if ($qaUpdate) {
            $qaUpdate->delete();
            return response("QA deleted successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error deleting QA: QA entry not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function updateQA(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'intialpolicyId' => 'required|exists:qAUpdates,policyId',
            'qaPolicies' => 'required',
            'year' => 'required|integer',
        ]);

        // Find the QA entry and update details
        $qaUpdate = QAUpdate::where('policyId', $validatedData['intialpolicyId'])->first();

        if ($qaUpdate) {
            $qaUpdate->update([
                'qaPolicies' => $validatedData['qaPolicies'],
                'year' => $validatedData['year']
            ]);

            return response("QA updated successfully", 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response("Error: QA entry not found", 404)
                ->header('Content-Type', 'text/plain');
        }
    }
    public function fetchCounts()
    {
        $totalQACount = QAUpdate::count();
        $courseCountBefore2023 = QAUpdate::where('year', '<', 2023)->count();
        $programCountAfter2023 = QAUpdate::where('year', '>', 2023)->count();

        $counts = "$totalQACount,$courseCountBefore2023,$programCountAfter2023";

        return response($counts, 200)
            ->header('Content-Type', 'text/plain');
    }
    public function fetchAllQAUpdates()
    {
        $qaUpdates = QAUpdate::all();

        return response()->json(['qaResults' => $qaUpdates]);
    }
}
