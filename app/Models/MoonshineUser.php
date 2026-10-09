<?php
namespace App\Models;

use MoonShine\Laravel\Models\MoonshineUser as BaseMoonshineUser;

class MoonshineUser extends BaseMoonshineUser
{
    public function isAdmin(): bool
    {
        return $this->moonshine_user_role_id === 1;
    }

    public function isCoordinador(): bool
    {
        return $this->moonshine_user_role_id === 2;
    }

    public function isDocente(): bool
    {
        return $this->moonshine_user_role_id === 3;
    }

    public function isAcudiente(): bool
    {
        return $this->moonshine_user_role_id === 4;
    }
}