<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Routes protected by Sanctum authentication.
 */
Route::middleware(['auth:sanctum'])->group(function () {

    // Path to get the authenticated user with their roles and permissions.
    Route::get('/user', function (Request $request) {
        return $request->user()->load(['roles', 'permissions']);
    });

    // Path to get the paginated list of users. Only accessible to users with the 'administrador' or 'revisor' role.
    Route::middleware(['role:administrador|revisor'])->get('/users', [DashboardController::class, 'index'])->name('users.index');

    /**
     * Route group for managing users, only accessible by the 'administrator' role.
     */
    Route::group(['middleware' => ['role:administrador']], function () {
        Route::post('/users', [DashboardController::class, 'store'])->name('users.store'); // Create a new user.
        Route::put('/users/{user}', [DashboardController::class, 'update']); // Update an existing user.
        Route::delete('/users/{user}', [DashboardController::class, 'destroy'])->name('users.destroy'); // Delete a user.
    });
});
