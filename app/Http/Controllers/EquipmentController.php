<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Equipment::class);

        $equipment = Equipment::query()
            ->search($request->query('search'))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('equipment.index', [
            'equipment' => $equipment,
            'search' => $request->query('search'),
        ]);
    }

    public function show(Equipment $equipment): View
    {
        $this->authorize('view', $equipment);

        return view('equipment.show', [
            'equipment' => $equipment,
        ]);
    }
}
