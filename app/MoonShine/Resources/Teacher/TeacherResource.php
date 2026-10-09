<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Teacher;

use App\Models\Teacher;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Components\Layout\Box;

class TeacherResource extends ModelResource
{
    protected string $model  = Teacher::class;
    protected string $title  = 'Docentes';
    protected string $column = 'nombre';
    protected bool $withPolicy = true;

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nombre', 'nombre')->sortable(),
            Text::make('Apellido', 'apellido')->sortable(),
            Text::make('Email', 'email'),
            Text::make('Materia', 'materia'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nombre', 'nombre')->required()->placeholder('Ej: Carlos'),
                Text::make('Apellido', 'apellido')->required()->placeholder('Ej: López'),
                Text::make('Email', 'email')->required()->placeholder('Ej: docente@iefr.edu.co'),
                Text::make('Teléfono', 'telefono')->placeholder('Ej: 3001234567'),
                Text::make('Materia', 'materia')->placeholder('Ej: Matemáticas'),
            ]),
        ];
    }

    protected function detailFields(): iterable { return $this->formFields(); }
    public function search(): array { return ['nombre', 'apellido', 'email', 'materia']; }
}