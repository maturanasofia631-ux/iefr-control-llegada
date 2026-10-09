<?php
namespace App\Policies;

use App\Models\MoonshineUser;
use App\Models\Student;

class StudentPolicy
{
    public function before(MoonshineUser $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }
    public function viewAny(MoonshineUser $user): bool  { return $user->isCoordinador() || $user->isDocente() || $user->isAcudiente(); }
    public function view(MoonshineUser $user, Student $s): bool { return $user->isCoordinador() || $user->isDocente() || $user->isAcudiente(); }
    public function create(MoonshineUser $user): bool   { return $user->isCoordinador(); }
    public function update(MoonshineUser $user, Student $s): bool { return $user->isCoordinador(); }
    public function delete(MoonshineUser $user, Student $s): bool { return false; }
    public function massDelete(MoonshineUser $user): bool { return false; }
}