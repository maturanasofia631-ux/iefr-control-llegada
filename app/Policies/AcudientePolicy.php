<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Acudiente;

class AcudientePolicy
{
    public function before(MoonshineUser $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(MoonshineUser $user): bool   { return $user->isCoordinador(); }
    public function view(MoonshineUser $user, Acudiente $a): bool { return $user->isCoordinador(); }
    public function create(MoonshineUser $user): bool    { return $user->isCoordinador(); }
    public function update(MoonshineUser $user, Acudiente $a): bool { return $user->isCoordinador(); }
    public function delete(MoonshineUser $user, Acudiente $a): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}