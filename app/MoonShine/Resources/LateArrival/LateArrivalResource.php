<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\LateArrival;

use App\Models\LateArrival;
use App\MoonShine\Resources\LateArrival\Pages\LateArrivalIndexPage;
use App\MoonShine\Resources\Student\StudentResource;
use App\MoonShine\Resources\Sanction\SanctionResource;
use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Components\Layout\Box;

class LateArrivalResource extends ModelResource
{
    protected string $model = LateArrival::class;
    protected string $title = 'Llegadas Tarde';
    protected bool $withPolicy = true;

    protected function pages(): array
    {
        return [
            LateArrivalIndexPage::class,
            FormPage::class,
            DetailPage::class,
        ];
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Estudiante', 'student', fn($item) => $item->codigo . ' — ' . $item->nombre, StudentResource::class)->searchable(),
            Date::make('Fecha', 'fecha')->sortable(),
            Text::make('Hora', 'hora'),
            Text::make('Motivo', 'motivo'),
            Switcher::make('¿Tiene excusa?', 'tiene_excusa'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                BelongsTo::make('Estudiante', 'student', fn($item) => $item->nombre, StudentResource::class)->required()->searchable(),
                Date::make('Fecha', 'fecha')->required()->default(now()->toDateString()),
                Text::make('Hora de llegada', 'hora')->required()->placeholder('Ej: 07:15'),
                Select::make('Motivo', 'motivo')->options([
                    'Transporte'  => 'Transporte',
                    'Salud'       => 'Salud',
                    'Familia'     => 'Familia',
                    'Cita médica' => 'Cita médica',
                    'Clima'       => 'Clima',
                    'Sin motivo'  => 'Sin motivo justificado',
                    'Otro'        => 'Otro',
                ])->required(),
                Switcher::make('¿Cuenta con excusa?', 'tiene_excusa'),
                Textarea::make('Observación', 'observacion')->placeholder('Notas adicionales...'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            BelongsTo::make('Estudiante', 'student', fn($item) => $item->nombre, StudentResource::class),
            Date::make('Fecha', 'fecha'),
            Text::make('Hora', 'hora'),
            Text::make('Motivo', 'motivo'),
            Switcher::make('¿Tiene excusa?', 'tiene_excusa'),
            Textarea::make('Observación', 'observacion'),
            HasMany::make('Sanción', 'sanction', resource: SanctionResource::class)->creatable(),
        ];
    }

    public function search(): array
    {
        return ['motivo', 'observacion'];
    }
}