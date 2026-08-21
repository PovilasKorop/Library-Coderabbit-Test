<?php

use App\Models\User;
use App\Role;

test('administrators can view user management page', function () {
    $admin = User::factory()->administrator()->create(['name' => 'Library Admin']);
    $member = User::factory()->member()->create(['name' => 'Borrower Member']);

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Library Admin')
        ->assertSee('Borrower Member');
});

test('administrators can create accounts with required fields', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'New Member',
            'email' => 'member@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'member',
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.users.index'));

    $user = User::query()->where('email', 'member@example.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->name)->toBe('New Member')
        ->and($user->role)->toBe(Role::Member)
        ->and($user->is_active)->toBeTrue();
});

test('administrators can update account role and active status', function () {
    $admin = User::factory()->administrator()->create();
    $member = User::factory()->member()->create([
        'name' => 'Existing Member',
        'email' => 'existing@example.com',
    ]);

    $this->actingAs($admin)
        ->put(route('admin.users.update', $member), [
            'name' => 'Promoted Member',
            'email' => 'existing@example.com',
            'role' => 'administrator',
            'is_active' => '0',
        ])
        ->assertRedirect(route('admin.users.index'));

    $member->refresh();

    expect($member->name)->toBe('Promoted Member')
        ->and($member->role)->toBe(Role::Administrator)
        ->and($member->is_active)->toBeFalse();
});

test('user creation validates required fields', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'password', 'role']);
});
