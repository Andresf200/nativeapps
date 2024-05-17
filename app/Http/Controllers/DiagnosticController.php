<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnosticRequest;
use App\Models\Diagnostic;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    public function index(Request $request)
    {
        $diagnostics = Diagnostic::query()
        ->allowedIncludes([])
        ->allowedFilters([])
        ->jsonPaginate();
        return $diagnostics;
    }

    public function store(DiagnosticRequest $request)
    {
        $diagnostic = Diagnostic::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Diagnostic created successfully',
            'data' => $diagnostic
        ]);
    }

    public function show($diagnostic)
    {
        return Diagnostic::query()
        ->allowedIncludes([])
        ->find($diagnostic);
    }

    public function update(DiagnosticRequest $request, Diagnostic $diagnostic)
    {
        if($diagnostic !== null){
            $diagnostic->fill([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            if ($diagnostic->isClean()) {
                return response()->json([
                    'message' => 'No especificaste ningún valor diferente',
                    'error' => 'No especificaste ningún valor diferente',
                ]);
            }

            $diagnostic->save();

            return response()->json([
                'message' => 'Diagnostic updated successfully',
                'data' => $diagnostic
            ]);
        }

        return response()->json([
            'message' => 'Diagnostic not found',
        ], 404);
    }

    public function destroy(Diagnostic $diagnostic)
    {
        $diagnostic->delete();

        return response()->json([
            'message' => 'Diagnostic deleted successfully',
        ]);
    }

    public function restore($diagnostic)
    {
        Diagnostic::onlyTrashed()->findOrFail($diagnostic)->restore();

        return response()->json([
            'message' => 'Diagnostic restored successfully',
        ]);
    }
}
