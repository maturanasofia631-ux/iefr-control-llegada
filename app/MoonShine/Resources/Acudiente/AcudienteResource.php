<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Acudiente;

use App\Models\Acudiente;
use App\MoonShine\Resources\Student\StudentResource;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Components\Layout\Box;

class AcudienteResource extends ModelResource
{
    protected string $model  = Acudiente::class;
    protected string $title  = 'Acudientes';
    protected string $column = 'nombre';
    protected bool $withPolicy = true;

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Estudiante', 'student', fn($item) => $item->nombre, StudentResource::class)->searchable(),
            Text::make('Nombre', 'nombre')->sortable(),
            Text::make('Apellido', 'apellido')->sortable(),
            Text::make('Teléfono', 'telefono'),
            Text::make('Parentesco', 'parentesco'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make('Estudiante', 'student', fn($item) => $item->nombre, StudentResource::class)->required()->searchable(),
                Text::make('Nombre', 'nombre')->required()->placeholder('Ej: María'),
                Text::make('Apellido', 'apellido')->required()->placeholder('Ej: García'),
                Text::make('Teléfono', 'telefono')->required()->placeholder('Ej: 3001234567'),
                Text::make('Email', 'email')->placeholder('Ej: acudiente@email.com'),
                Select::make('Parentesco', 'parentesco')->options([
                    'Madre'   => 'Madre',
                    'Padre'   => 'Padre',
                    'Abuelo'  => 'Abuelo',
                    'Abuela'  => 'Abuela',
                    'Tio'     => 'Tío',
                    'Tia'     => 'Tía',
                    'Hermano' => 'Hermano',
                    'Otro'    => 'Otro',
                ])->required(),
            ]),
        ];
    }

    protected function detailFields(): iterable { return $this->formFields(); }
    public function search(): array { return ['nombre', 'apellido', 'telefono', 'parentesco']; }
}