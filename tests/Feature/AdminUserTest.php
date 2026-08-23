<?php

use App\Models\User;
use App\Role;

test('members cannot access user management', function () {
    $member = User::factory()->member()->create();
    $otherUser = User::factory()->member()->create();

    $this->actingAs($member)
        ->get(route('admin.users.index'))
        ->assertForbidden();

    $this->actingAs($member)
        ->post(route('admin.users.store'), [
            'name' => 'New Member',
            'email' => 'new@example.com',
            'password' => 'password',
            'role' => Role::Member->value,
            'is_active' => true,
        ])
        ->assertForbidden();

    $this->actingAs($member)
        ->put(route('admin.users.update', $otherUser), [
            'name' => 'Changed Name',
            'email' => $otherUser->email,
            'role' => Role::Member->value,
            'is_active' => true,
        ])
        ->assertForbidden();
});

test('administrators can create and update accounts', function () {
    $admin = User::factory()->administrator()->create();
    $existingUser = User::factory()->member()->create([
        'name' => 'Existing Member',
        'email' => 'existing@example.com',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'Invited Member',
            'email' => 'invited@example.com',
            'password' => 'password',
            'role' => Role::Member->value,
            'is_active' => true,
        ])
        ->assertRedirect(route('admin.users.index'));

    $createdUser = User::query()->where('email', 'invited@example.com')->first();

    expect($createdUser)
        ->not->toBeNull()
        ->name->toBe('Invited Member')
        ->role->toBe(Role::Member)
        ->is_active->toBeTrue();

    $this->actingAs($admin)
        ->put(route('admin.users.update', $existingUser), [
            'name' => 'Updated Member',
            'email' => 'updated@example.com',
            'role' => Role::Administrator->value,
            'is_active' => false,
        ])
        ->assertRedirect(route('admin.users.index'));

    expect($existingUser->fresh())
        ->name->toBe('Updated Member')
        ->email->toBe('updated@example.com')
        ->role->toBe(Role::Administrator)
        ->is_active->toBeFalse();
});

test('user creation validates required fields', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [])
        ->assertSessionHasErrors(['name', 'email', 'password', 'role']);
});
