<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\Student\StudentResource;
use App\MoonShine\Resources\LateArrival\LateArrivalResource;
use App\MoonShine\Resources\Teacher\TeacherResource;
use App\MoonShine\Resources\Excuse\ExcuseResource;
use App\MoonShine\Resources\Sanction\SanctionResource;
use App\MoonShine\Resources\Acudiente\AcudienteResource;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\Ability;
use Illuminate\Database\Eloquent\Model;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core, MoonShineConfigurator $config): void
{

    $config->authorizationRules(
        static function (
            ResourceContract $resource,
            Model $user,
            Ability $ability,
            Model $item
        ): bool {
            // Si el recurso no es un ModelResource, permitir (ej. páginas)
            if (! $resource instanceof ModelResource) {
                return true;
            }

            $model = $resource->getModel()::class;
            $esSistema = str_contains($model, 'MoonshineUser');

            return ! $esSistema || $user->isAdmin();
        }
    );

    $core
        ->resources([
            MoonShineUserResource::class,
            MoonShineUserRoleResource::class,
            StudentResource::class,
            LateArrivalResource::class,
            TeacherResource::class,
            ExcuseResource::class,
            SanctionResource::class,
            AcudienteResource::class,
        ])
        ->pages([
            ...$core->getConfig()->getPages(),
        ])
    ;
}
}
