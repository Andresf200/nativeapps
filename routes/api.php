<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\DiagnosticPatientController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('patients', PatientController::class);
Route::patch('patients/{patient}/restore', [PatientController::class, 'restore']);


Route::get('diagnostics/frequents', [DiagnosticController::class, 'mostFrequent']);
Route::apiResource('diagnostics', DiagnosticController::class);
Route::patch('diagnostics/{diagnostic}/restore', [DiagnosticController::class, 'restore']);

Route::post('diagnostic-patients', [DiagnosticPatientController::class, 'store']);

