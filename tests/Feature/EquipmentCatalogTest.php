<?php

use App\Models\Equipment;
use App\Models\User;

test('guests are redirected to login when browsing equipment catalog', function () {
    $this->get(route('equipment.index'))
        ->assertRedirect(route('login'));
});

test('members can browse equipment catalog ordered by name', function () {
    $member = User::factory()->member()->create();

    $zItem = Equipment::factory()->create(['name' => 'Zeta Drill']);
    $aItem = Equipment::factory()->create(['name' => 'Alpha Saw']);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertSuccessful()
        ->assertSeeInOrder([$aItem->name, $zItem->name]);
});

test('members can search equipment by name or category', function () {
    $member = User::factory()->member()->create();

    $matchingByName = Equipment::factory()->create(['name' => 'Cordless Drill', 'category' => 'Power Tools']);
    $matchingByCategory = Equipment::factory()->create(['name' => 'Leaf Blower', 'category' => 'Garden']);
    $nonMatching = Equipment::factory()->create(['name' => 'Hammer', 'category' => 'Hand Tools']);

    $this->actingAs($member)
        ->get(route('equipment.index', ['search' => 'Garden']))
        ->assertSuccessful()
        ->assertSee($matchingByCategory->name)
        ->assertDontSee($matchingByName->name)
        ->assertDontSee($nonMatching->name);

    $this->actingAs($member)
        ->get(route('equipment.index', ['search' => 'Drill']))
        ->assertSuccessful()
        ->assertSee($matchingByName->name)
        ->assertDontSee($matchingByCategory->name);
});

test('equipment catalog paginates twenty items per page', function () {
    $member = User::factory()->member()->create();

    Equipment::factory()->count(21)->create();

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertSuccessful()
        ->assertViewHas('equipment', fn ($paginator) => $paginator->count() === 20 && $paginator->total() === 21);
});

test('members can view equipment detail page', function () {
    $member = User::factory()->member()->create();
    $equipment = Equipment::factory()->create([
        'name' => 'Pressure Washer',
        'description' => 'High pressure washer for outdoor cleaning.',
    ]);

    $this->actingAs($member)
        ->get(route('equipment.show', $equipment))
        ->assertSuccessful()
        ->assertSee($equipment->name)
        ->assertSee($equipment->description);
});

test('maintenance equipment shows unavailable label in catalog and detail', function () {
    $member = User::factory()->member()->create();
    $equipment = Equipment::factory()->maintenance()->create(['name' => 'Broken Ladder']);

    $this->actingAs($member)
        ->get(route('equipment.index'))
        ->assertSuccessful()
        ->assertSee('Unavailable')
        ->assertSee($equipment->name);

    $this->actingAs($member)
        ->get(route('equipment.show', $equipment))
        ->assertSuccessful()
        ->assertSee('Unavailable');
});
