<?php

use App\EquipmentStatus;
use App\Models\Equipment;
use App\Models\User;

test('members cannot access admin equipment routes', function () {
    $member = User::factory()->member()->create();
    $equipment = Equipment::factory()->create();

    $this->actingAs($member)
        ->get(route('admin.equipment.index'))
        ->assertForbidden();

    $this->actingAs($member)
        ->get(route('admin.equipment.create'))
        ->assertForbidden();

    $this->actingAs($member)
        ->post(route('admin.equipment.store'), [
            'name' => 'New Item',
            'category' => 'Tools',
            'status' => EquipmentStatus::Active->value,
        ])
        ->assertForbidden();

    $this->actingAs($member)
        ->get(route('admin.equipment.edit', $equipment))
        ->assertForbidden();

    $this->actingAs($member)
        ->put(route('admin.equipment.update', $equipment), [
            'name' => 'Updated Item',
            'category' => 'Tools',
            'status' => EquipmentStatus::Active->value,
        ])
        ->assertForbidden();

    $this->actingAs($member)
        ->delete(route('admin.equipment.destroy', $equipment))
        ->assertForbidden();
});

test('administrators can manage equipment', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->get(route('admin.equipment.create'))
        ->assertSuccessful();

    $this->actingAs($admin)
        ->post(route('admin.equipment.store'), [
            'name' => 'Jigsaw',
            'category' => 'Power Tools',
            'status' => EquipmentStatus::Maintenance->value,
        ])
        ->assertRedirect(route('admin.equipment.edit', Equipment::query()->where('name', 'Jigsaw')->first()));

    $jigsaw = Equipment::query()->where('name', 'Jigsaw')->firstOrFail();

    $this->actingAs($admin)
        ->put(route('admin.equipment.update', $jigsaw), [
            'name' => 'Updated Jigsaw',
            'category' => 'Power Tools',
            'status' => EquipmentStatus::Active->value,
        ])
        ->assertRedirect(route('admin.equipment.edit', $jigsaw));

    expect($jigsaw->fresh())
        ->name->toBe('Updated Jigsaw')
        ->status->toBe(EquipmentStatus::Active);

    $this->actingAs($admin)
        ->delete(route('admin.equipment.destroy', $jigsaw))
        ->assertRedirect(route('admin.equipment.index'));

    $this->assertDatabaseMissing('equipment', ['id' => $jigsaw->id]);
});

test('admin equipment creation validates required fields', function () {
    $admin = User::factory()->administrator()->create();

    $this->actingAs($admin)
        ->post(route('admin.equipment.store'), [])
        ->assertSessionHasErrors(['name', 'category', 'status']);
});
