<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\LateArrival;

class LateArrivalPolicy
{
    public function before(MoonshineUser $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }
    public function viewAny(MoonshineUser $user): bool  { return true; }
    public function view(MoonshineUser $user, LateArrival $l): bool { return true; }
    public function create(MoonshineUser $user): bool   { return $user->isCoordinador() || $user->isDocente(); }
    public function update(MoonshineUser $user, LateArrival $l): bool { return $user->isCoordinador(); }
    public function delete(MoonshineUser $user, LateArrival $l): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}