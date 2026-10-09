<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Sanction;

class SanctionPolicy
{
    public function before(MoonshineUser $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(MoonshineUser $user): bool
    {
        return $user->isCoordinador() || $user->isDocente();
    }

    public function view(MoonshineUser $user, Sanction $s): bool
    {
        return $user->isCoordinador() || $user->isDocente();
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isCoordinador();
    }

    public function update(MoonshineUser $user, Sanction $s): bool
    {
        return $user->isCoordinador();
    }

    public function delete(MoonshineUser $user, Sanction $s): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}