<?php
declare(strict_types=1);
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;
use MoonShine\AssetManager\Css;
use App\MoonShine\Resources\Student\StudentResource;
use App\MoonShine\Resources\LateArrival\LateArrivalResource;
use App\MoonShine\Resources\Teacher\TeacherResource;
use App\MoonShine\Resources\Excuse\ExcuseResource;
use App\MoonShine\Resources\Sanction\SanctionResource;
use App\MoonShine\Resources\Acudiente\AcudienteResource;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
            Css::make(asset('css/moonshine-custom.css')),
        ];
    }

    protected function menu(): array
    {
        /** @var \App\Models\MoonshineUser|null $user */
        $user = auth('moonshine')->user();

        $menuCoordinador = [
            MenuGroup::make('Gestión Escolar', [
                MenuItem::make(StudentResource::class,   'Estudiantes',   icon: 'academic-cap'),
                MenuItem::make(TeacherResource::class,   'Docentes',      icon: 'user-group'),
                MenuItem::make(AcudienteResource::class, 'Acudientes',    icon: 'users'),
                
            ], icon: 'building-library'),
            MenuGroup::make('Control de Tardanzas', [
                MenuItem::make(LateArrivalResource::class, 'Llegadas Tarde', icon: 'clock'),
                MenuItem::make(ExcuseResource::class,      'Excusas',        icon: 'document-check'),
                MenuItem::make(SanctionResource::class,    'Sanciones',      icon: 'exclamation-triangle'),
            ], icon: 'clipboard-document-list'),
        ];

        $menuDocente = [
            MenuGroup::make('Control de Tardanzas', [
                MenuItem::make(LateArrivalResource::class, 'Llegadas Tarde', icon: 'clock'),
            ], icon: 'clipboard-document-list'),
        ];

        $menuAcudiente = [
            MenuGroup::make('Información', [
                MenuItem::make(StudentResource::class,    'Estudiantes',   icon: 'academic-cap'),
                MenuItem::make(LateArrivalResource::class,'Llegadas Tarde',icon: 'clock'),
            ], icon: 'building-library'),
        ];

        if ($user?->isAdmin() || $user?->isCoordinador()) {
            return [...parent::menu(), ...$menuCoordinador];
        }

        if ($user?->isDocente()) {
            return [...parent::menu(), ...$menuDocente];
        }

        if ($user?->isAcudiente()) {
            return [...parent::menu(), ...$menuAcudiente];
        }

        return [...parent::menu(), ...$menuDocente];
    }

    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        $colorManager
            ->primary('#8B1A1A')
            ->secondary('#2e7fcf')
            ->body('249, 249, 249')
            ->dark('15, 15, 15',    'DEFAULT')
            ->dark('249, 249, 249',  50)
            ->dark('240, 240, 240', 100)
            ->dark('212, 212, 212', 200)
            ->dark('138, 138, 138', 300)
            ->dark('92,  92,  92',  400)
            ->dark('58,  58,  58',  500)
            ->dark('58,  58,  58',  600)
            ->dark('30,  30,  30',  700)
            ->dark('20,  20,  20',  800)
            ->dark('15,  15,  15',  900)
            ->successBg('218, 234, 218')
            ->successText('46, 127, 79')
            ->warningBg('247, 235, 200')
            ->warningText('133, 95, 11')
            ->errorBg('252, 234, 234')
            ->errorText('224, 58, 58')
            ->infoBg('232, 242, 251')
            ->infoText('46, 127, 207')
            ->body('15, 15, 15', dark: true);
    }

    protected function getFooterCopyright(): string
    {
        return '© ' . date('Y') . ' I.E. Felipe de Restrepo — Control de llegadas tarde';
    }

    protected function getFooterMenu(): array
    {
        return ['/' => 'Inicio'];
    }
}