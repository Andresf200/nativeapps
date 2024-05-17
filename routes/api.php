<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DiagnosticController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('patients', PatientController::class);
Route::patch('patients/{patient}/restore', [PatientController::class, 'restore']);

Route::apiResource('diagnostics', DiagnosticController::class);
Route::patch('diagnostics/{diagnostic}/restore', [DiagnosticController::class, 'restore']);
