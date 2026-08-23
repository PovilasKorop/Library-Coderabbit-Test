<?php

use App\Models\User;

test('inactive users cannot log in', function () {
    User::factory()->inactive()->create([
        'email' => 'inactive@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login'), [
        'email' => 'inactive@example.com',
        'password' => 'password',
    ])->assertSessionHasErrors(['email']);
});

test('deactivated users are logged out on the next protected request', function () {
    $member = User::factory()->member()->create();

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertSuccessful();

    $member->update(['is_active' => false]);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('guests are redirected to login for protected routes', function () {
    $this->get(route('equipment.index'))
        ->assertRedirect(route('login'));

    $this->get(route('admin.equipment.index'))
        ->assertRedirect(route('login'));
});
