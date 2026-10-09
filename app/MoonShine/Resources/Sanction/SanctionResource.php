<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Sanction;

use App\Models\Sanction;
use App\MoonShine\Resources\Student\StudentResource;
use App\MoonShine\Resources\LateArrival\LateArrivalResource;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\ActionButton;

class SanctionResource extends ModelResource
{
    protected string $model = Sanction::class;
    protected string $title = 'Sanciones';
    protected bool $withPolicy = true;

    protected function indexFields(): iterable
    {
        return [
            BelongsTo::make('Estudiante', 'student', fn($item) => $item->codigo . ' — ' . $item->nombre, StudentResource::class)->searchable(),
            BelongsTo::make('Llegada Tarde', 'lateArrival',
                fn($item) => \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') . ' — ' . $item->motivo,
                LateArrivalResource::class
            ),
            Text::make('Tipo', 'tipo'),
            Date::make('Fecha', 'fecha')->sortable(),
            Text::make('Estado', 'estado'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make('Estudiante', 'student', fn($item) => $item->nombre, StudentResource::class)->required()->searchable(),
                BelongsTo::make('Llegada Tarde relacionada', 'lateArrival',
                    fn($item) => $item->student?->nombre . ' — ' . \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') . ' (' . $item->motivo . ')',
                    LateArrivalResource::class
                )->nullable()->searchable(),
                Select::make('Tipo', 'tipo')->options([
                    'Llamado de atencion' => 'Llamado de atención',
                    'Citacion acudiente'  => 'Citación al acudiente',
                    'Suspension'          => 'Suspensión',
                    'Otro'                => 'Otro',
                ])->required(),
                Textarea::make('Descripción', 'descripcion')->placeholder('Detalle de la sanción...'),
                Date::make('Fecha', 'fecha')->required()->default(now()->toDateString()),
                Select::make('Estado', 'estado')->options([
                    'activa'    => 'Activa',
                    'resuelta'  => 'Resuelta',
                    'cancelada' => 'Cancelada',
                ])->default('activa'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return $this->formFields();
    }

    /**
     * Botones de acción del index.
     * Solo Admin y Coordinador ven los botones de exportación.
     */
    protected function indexButtons(): array
    {
        /** @var \App\Models\MoonshineUser|null $user */
        $user = auth('moonshine')->user();

        if (! $user || (! $user->isAdmin() && ! $user->isCoordinador())) {
            return [];
        }

        return [
            ActionButton::make('Excel', route('exports.sanctions.excel'))
                ->icon('table-cells'),
            ActionButton::make('PDF', route('exports.sanctions.pdf'))
                ->icon('document-arrow-down'),
        ];
    }

    public function search(): array
    {
        return ['tipo', 'descripcion', 'estado'];
    }
}