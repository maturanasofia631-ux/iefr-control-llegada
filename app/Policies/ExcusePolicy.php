<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Excuse;

class ExcusePolicy
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

    public function view(MoonshineUser $user, Excuse $e): bool
    {
        return $user->isCoordinador() || $user->isDocente();
    }

    public function create(MoonshineUser $user): bool
    {
        return $user->isCoordinador() || $user->isDocente();
    }

    public function update(MoonshineUser $user, Excuse $e): bool
    {
        return $user->isCoordinador();
    }

    public function delete(MoonshineUser $user, Excuse $e): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}