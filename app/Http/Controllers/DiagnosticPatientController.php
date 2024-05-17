<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\DiagnosticPatientRequest;

class DiagnosticPatientController extends Controller
{
    public function store(DiagnosticPatientRequest $request){
        $patient = Patient::findOrFail($request->patient_id);

        $patient->diagnostics()->attach($request->diagnostic_id, [
            'observation' => $request->input('observation', null),
            'creation' => now()
        ]);

        return response()->json([
            'message' => 'Diagnostic attached to patient'
        ]);
    }
}
