<?php

use App\Models\Equipment;
use App\Models\User;

test('members cannot access administrator routes', function () {
    $member = User::factory()->member()->create();

    $this->actingAs($member)
        ->get(route('admin.users.index'))
        ->assertForbidden();

    $this->actingAs($member)
        ->get(route('admin.equipment.index'))
        ->assertForbidden();

    $this->actingAs($member)
        ->post(route('admin.users.store'), [])
        ->assertForbidden();

    $equipment = Equipment::factory()->create();

    $this->actingAs($member)
        ->post(route('admin.equipment.store'), [])
        ->assertForbidden();

    $this->actingAs($member)
        ->put(route('admin.equipment.update', $equipment), [])
        ->assertForbidden();
});

test('deactivated accounts are logged out on the next protected request', function () {
    $member = User::factory()->member()->create(['is_active' => true]);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertOk();

    $member->update(['is_active' => false]);

    $this->actingAs($member->fresh())
        ->get(route('equipment.index'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('inactive users cannot authenticate', function () {
    $member = User::factory()->member()->inactive()->create([
        'email' => 'inactive@example.com',
    ]);

    $this->post(route('login.store'), [
        'email' => $member->email,
        'password' => 'password',
    ])->assertSessionHasNoErrors();

    $this->get(route('equipment.index'))
        ->assertRedirect(route('login'));
});

test('guests are redirected to login for protected routes', function () {
    $equipment = Equipment::factory()->create();

    $this->get(route('equipment.index'))
        ->assertRedirect(route('login'));

    $this->get(route('equipment.show', $equipment))
        ->assertRedirect(route('login'));

    $this->get(route('admin.users.index'))
        ->assertRedirect(route('login'));
});
