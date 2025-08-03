<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{actingAs, postJson, putJson, deleteJson, getJson};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'administrador']);
    Role::create(['name' => 'revisor']);
});

it('allows an "adminstrador" to view the list of records', function () {
    $admin = User::factory()->create()->assignRole('administrador');

    actingAs($admin)
        ->getJson('/api/users')
        ->assertOk()
        ->assertJsonStructure(['data', 'total', 'per_page']);
});

it('allows a "revisor" to view the list of records', function () {
    $revisor = User::factory()->create()->assignRole('revisor');

    actingAs($revisor)
        ->getJson('/api/users')
        ->assertOk();
});

it('denies access to users without a role to the list of records', function () {
    $user = User::factory()->create(); // sin rol

    actingAs($user)
        ->getJson('/api/users')
        ->assertForbidden();
});

it('allows an "adminstrador" to create a record', function () {
    Mail::fake();

    $admin = User::factory()->create()->assignRole('administrador');

    $nuevoUsuario = [
        'firstname' => 'Juan',
        'lastname' => 'Pérez',
        'email' => 'juan@example.com',
        'password' => 'secret123',
        'role' => 'revisor',
    ];

    actingAs($admin)
        ->postJson('/api/users', $nuevoUsuario)
        ->assertCreated()
        ->assertJson(['message' => 'User created successfully']);

    expect(User::where('email', 'juan@example.com')->exists())->toBeTrue();
});

it('prevents a "revisor" from creating a record', function () {
    $revisor = User::factory()->create()->assignRole('revisor');

    actingAs($revisor)
        ->postJson('/api/users', [
            'firstname' => 'X',
            'lastname' => 'Y',
            'email' => 'x@y.com',
            'password' => '12345678',
            'role' => 'revisor',
        ])
        ->assertForbidden();
});

it('allows an "adminstrador" to update a record', function () {
    Mail::fake();

    $admin = User::factory()->create()->assignRole('administrador');
    $user = User::factory()->create()->assignRole('revisor');

    $data = [
        'firstname' => 'NuevoNombre',
        'lastname' => 'Apellido',
        'email' => $user->email,
        'role' => 'revisor',
    ];

    actingAs($admin)
        ->putJson("/api/users/{$user->id}", $data)
        ->assertOk()
        ->assertJson(['message' => 'User updated successfully']);

    expect(User::find($user->id)->firstname)->toBe('NuevoNombre');
});

it('allows an "adminstrador" to delete a record', function () {
    $admin = User::factory()->create()->assignRole('administrador');
    $user = User::factory()->create();

    actingAs($admin)
        ->deleteJson("/api/users/{$user->id}")
        ->assertOk()
        ->assertJson(['message' => 'User deleted successfully']);

    expect(User::find($user->id))->toBeNull();
});