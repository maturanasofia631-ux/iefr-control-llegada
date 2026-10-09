<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Teacher;

class TeacherPolicy
{
    public function before(MoonshineUser $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(MoonshineUser $user): bool   { return $user->isCoordinador(); }
    public function view(MoonshineUser $user, Teacher $t): bool { return $user->isCoordinador(); }
    public function create(MoonshineUser $user): bool    { return $user->isCoordinador(); }
    public function update(MoonshineUser $user, Teacher $t): bool { return $user->isCoordinador(); }
    public function delete(MoonshineUser $user, Teacher $t): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}