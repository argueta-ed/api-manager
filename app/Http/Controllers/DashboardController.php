<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateRequest;
use App\Mail\SendCredentialsMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Controller to handle user CRUD operations on the dashboard.
 */
class DashboardController extends Controller
{
    /**
     * Display a paginated list of users with their roles and permissions.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // Get users with their roles and permissions, paginated (10 per page)
        $registros = User::with(['roles', 'permissions'])->paginate(10);

        return response()->json($registros);
    }

    /**
     * Create a new user with validated data and assign a role.
     * Also sends an email with the new user's credentials.
     *
     * @param RegisterRequest $request Request with custom validation
     * @return JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        // Create user with hashed password and assign role
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ])->assignRole($request->input('role'));

        // Send email with credentials to the newly created user
        Mail::to($user->email)->send(new SendCredentialsMail($user->email, $request->input('password')));

        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Update an existing user's data.
     * Synchronizes roles and, if the password is changed, sends an email with new credentials.
     *
     * @param UpdateRequest $request Request with custom validation
     * @param User $user User to update (automatic route injection)
     * @return \JsonResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        // Update user with validated data
        $user->update($request->validated());
        // Synchronize assigned roles
        $user->syncRoles($request->input('role'));

        // If password is updated, send email with new credentials
        if (!empty($request->input('password'))) {
            Mail::to($user->email)->send(new SendCredentialsMail($user->email, $request->input('password'), 'emails.credentials_updated'));
        }

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Delete a user from the system.
     *
     * @param User $user User to delete (automatic path injection)
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
