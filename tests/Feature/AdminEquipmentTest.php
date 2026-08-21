<?php

use App\EquipmentStatus;
use App\Models\Equipment;
use App\Models\User;

test('administrators can view equipment management index', function () {
    $admin = User::factory()->administrator()->create();
    $equipment = Equipment::factory()->create(['name' => 'Admin Listed Drill']);

    $this->actingAs($admin)
        ->get(route('admin.equipment.index'))
        ->assertOk()
        ->assertSee('Admin Listed Drill');
});

test('administrators can create equipment and are redirected to edit page', function () {
    $admin = User::factory()->administrator()->create();

    $response = $this->actingAs($admin)->post(route('admin.equipment.store'), [
        'name' => 'Community Ladder',
        'category' => 'Ladders',
        'description' => '12-foot extension ladder.',
        'status' => 'active',
    ]);

    $equipment = Equipment::query()->where('name', 'Community Ladder')->first();

    expect($equipment)->not->toBeNull()
        ->and($equipment->category)->toBe('Ladders')
        ->and($equipment->description)->toBe('12-foot extension ladder.')
        ->and($equipment->status)->toBe(EquipmentStatus::Active);

    $response->assertRedirect(route('admin.equipment.edit', $equipment));
});

test('administrators can update equipment', function () {
    $admin = User::factory()->administrator()->create();
    $equipment = Equipment::factory()->create(['name' => 'Old Name']);

    $this->actingAs($admin)
        ->put(route('admin.equipment.update', $equipment), [
            'name' => 'Updated Name',
            'category' => 'Updated Category',
            'description' => 'Updated description.',
            'status' => 'maintenance',
        ])
        ->assertRedirect(route('admin.equipment.edit', $equipment));

    $equipment->refresh();

    expect($equipment->name)->toBe('Updated Name')
        ->and($equipment->category)->toBe('Updated Category')
        ->and($equipment->description)->toBe('Updated description.')
        ->and($equipment->status)->toBe(EquipmentStatus::Maintenance);
});

test('administrators can delete equipment', function () {
    $admin = User::factory()->administrator()->create();
    $equipment = Equipment::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.equipment.destroy', $equipment))
        ->assertRedirect(route('admin.equipment.index'));

    $this->assertDatabaseMissing('equipment', ['id' => $equipment->id]);
});

test('equipment creation validates required fields', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->post(route('admin.equipment.store'), [])
        ->assertSessionHasErrors(['name', 'category', 'status']);
});
