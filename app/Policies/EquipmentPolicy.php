<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;

class EquipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Equipment $equipment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Equipment $equipment): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user, Equipment $equipment): bool
    {
        return $user->isAdministrator();
    }
}
