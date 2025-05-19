<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\Api\TaskmanagementController;
use App\Http\Controllers\Backend\Api\PermissionController;
use App\Http\Controllers\Backend\Api\ApiController;

// Public route for mobile login
Route::post('/admin/api-login', [LoginController::class, 'apiLogin']);

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!'], 200);
});


// Admin profile route with auth middleware
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('profile', [ApiController::class, 'profile']);
    Route::post('update-profile', [ApiController::class, 'updateProfile']);
    Route::get('/task-management', [TaskmanagementController::class, 'index']);
    Route::post('/task-management/store', [TaskmanagementController::class, 'store']);
    Route::get('/task-management/show/{id}', [TaskmanagementController::class, 'show']);
    Route::post('/task-management/update/{id}', [TaskmanagementController::class, 'update']);
    Route::delete('/task-management/delete/{id}', [TaskmanagementController::class, 'destroy']);
     Route::get('/modules-permission', [PermissionController::class, 'modulesPermission']);

});



