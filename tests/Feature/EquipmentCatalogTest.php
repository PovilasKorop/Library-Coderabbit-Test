<?php

use App\EquipmentStatus;
use App\Models\Equipment;
use App\Models\User;

test('guests are redirected to login when browsing equipment catalog', function () {
    $this->get(route('equipment.index'))
        ->assertRedirect(route('login'));
});

test('members can browse equipment catalog ordered by name', function () {
    $member = User::factory()->member()->create();

    $zebraDrill = Equipment::factory()->create(['name' => 'Zebra Drill']);
    $alphaSaw = Equipment::factory()->create(['name' => 'Alpha Saw']);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertOk()
        ->assertSeeInOrder(['Alpha Saw', 'Zebra Drill']);
});

test('equipment catalog paginates twenty items per page', function () {
    $member = User::factory()->member()->create();

    Equipment::factory()->count(21)->create();

    $response = $this->actingAs($member)->get(route('equipment.index'));

    $response->assertOk();
    expect($response->viewData('equipment'))->toHaveCount(20);
});

test('members can search equipment by name or category', function () {
    $member = User::factory()->member()->create();

    $matchingByName = Equipment::factory()->create(['name' => 'Cordless Drill', 'category' => 'Power Tools']);
    $matchingByCategory = Equipment::factory()->create(['name' => 'Leaf Blower', 'category' => 'Garden Equipment']);
    $nonMatching = Equipment::factory()->create(['name' => 'Hammer', 'category' => 'Hand Tools']);

    $this->actingAs($member)
        ->get(route('equipment.index', ['search' => 'Drill']))
        ->assertOk()
        ->assertSee($matchingByName->name)
        ->assertDontSee($matchingByCategory->name)
        ->assertDontSee($nonMatching->name);

    $this->actingAs($member)
        ->get(route('equipment.index', ['search' => 'Garden']))
        ->assertOk()
        ->assertSee($matchingByCategory->name)
        ->assertDontSee($matchingByName->name)
        ->assertDontSee($nonMatching->name);
});

test('maintenance equipment remains visible with unavailable label', function () {
    $member = User::factory()->member()->create();

    $maintenanceEquipment = Equipment::factory()->maintenance()->create(['name' => 'Broken Ladder']);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertOk()
        ->assertSee($maintenanceEquipment->name)
        ->assertSee('Unavailable');

    $this->actingAs($member)
        ->get(route('equipment.show', $maintenanceEquipment))
        ->assertOk()
        ->assertSee($maintenanceEquipment->name)
        ->assertSee('Unavailable');
});

test('members can view equipment detail page', function () {
    $member = User::factory()->member()->create();
    $equipment = Equipment::factory()->create([
        'name' => 'Pressure Washer',
        'category' => 'Cleaning',
        'description' => 'High pressure outdoor cleaner.',
        'status' => EquipmentStatus::Active,
    ]);

    $this->actingAs($member)
        ->get(route('equipment.show', $equipment))
        ->assertOk()
        ->assertSee('Pressure Washer')
        ->assertSee('Cleaning')
        ->assertSee('High pressure outdoor cleaner.');
});
