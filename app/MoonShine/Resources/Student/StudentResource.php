<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Student;

use App\Models\Student;
use App\MoonShine\Resources\LateArrival\LateArrivalResource;
use App\MoonShine\Resources\Acudiente\AcudienteResource;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Components\Layout\Box;

class StudentResource extends ModelResource
{
    protected string $model  = Student::class;
    protected string $title  = 'Estudiantes';
    protected string $column = 'nombre';
    protected bool $withPolicy = true;

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nombre', 'nombre')->sortable(),
            Text::make('Grado', 'grado')->sortable(),
            Text::make('Grupo', 'grupo')->sortable(),
            Text::make('Código', 'codigo'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nombre completo', 'nombre')->required()->placeholder('Ej: GARCIA MEJIA JUAN JOSE'),
                Text::make('Grado', 'grado')->required()->placeholder('Ej: 10'),
                Text::make('Grupo', 'grupo')->required()->placeholder('Ej: 10°1'),
                Text::make('Código / Matrícula', 'codigo')->placeholder('Ej: 260184'),
                Textarea::make('Observaciones', 'observaciones'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre', 'nombre'),
            Text::make('Grado', 'grado'),
            Text::make('Grupo', 'grupo'),
            Text::make('Código', 'codigo'),
            Textarea::make('Observaciones', 'observaciones'),
            HasMany::make('Llegadas Tarde', 'lateArrivals', resource: LateArrivalResource::class)->creatable(),
            HasMany::make('Acudientes', 'acudientes', resource: AcudienteResource::class)->creatable(),
        ];
    }

    public function search(): array
    {
        return ['nombre', 'codigo', 'grado', 'grupo'];
    }
}