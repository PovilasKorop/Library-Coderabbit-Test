<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Equipment::class);

        $equipment = Equipment::query()
            ->orderBy('name')
            ->paginate(20);

        return view('admin.equipment.index', [
            'equipment' => $equipment,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Equipment::class);

        return view('admin.equipment.create');
    }

    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $equipment = Equipment::query()->create($request->validated());

        return redirect()->route('admin.equipment.edit', $equipment);
    }

    public function edit(Equipment $equipment): View
    {
        $this->authorize('update', $equipment);

        return view('admin.equipment.edit', [
            'equipment' => $equipment,
        ]);
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $equipment->update($request->validated());

        return redirect()->route('admin.equipment.edit', $equipment);
    }

    public function destroy(Equipment $equipment): RedirectResponse
    {
        $this->authorize('delete', $equipment);

        $equipment->delete();

        return redirect()->route('admin.equipment.index');
    }
}
