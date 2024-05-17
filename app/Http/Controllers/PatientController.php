<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::query()
        ->allowedIncludes(['diagnostics'])
        ->allowedFilters(['name', 'document'])
        ->jsonPaginate();

        return $patients;
    }

    public function store(PatientRequest $request)
    {
        $patient = Patient::create([
            'document' => $request->document,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'phone' => $request->phone,
            'genre' => $request->genre
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'valid' => $patient
        ]);
    }

    public function show($patient)
    {
        return Patient::query()
        ->allowedIncludes(['diagnostics'])
        ->findOrFail($patient);
    }

    public function update(PatientRequest $request, Patient $patient)
    {
        if($patient !== null){
            $patient->fill([
                'document' => $request->document,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'email' => $request->email,
                'phone' => $request->phone,
                'genre' => $request->genre
            ]);

            if ($patient->isClean()) {
                return response()->json([
                    'message' => 'No especificaste ningún valor diferente',
                    'error' => 'No especificaste ningún valor diferente',
                ]);
            }

            $patient->save();

            return response()->json([
                'message' => 'Patient updated successfully',
                'valid' => $patient
            ]);
        }
        return response()->json([
            'message' => 'Patient not found'
        ]);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }

    public function restore($patient)
    {
        $patient = Patient::onlyTrashed()->findOrFail($patient);
        $patient->restore();

        return response()->json([
            'message' => 'Patient restored successfully'
        ]);
    }

}
