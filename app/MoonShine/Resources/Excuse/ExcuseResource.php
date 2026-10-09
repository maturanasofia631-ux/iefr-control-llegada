<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Excuse;

use App\Models\Excuse;
use App\MoonShine\Resources\LateArrival\LateArrivalResource;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Components\Layout\Box;

class ExcuseResource extends ModelResource
{
    protected string $model = Excuse::class;
    protected string $title = 'Excusas';
    protected bool $withPolicy = true;

    protected function indexFields(): iterable
    {
        return [
            BelongsTo::make('Llegada Tarde', 'lateArrival',
                fn($item) => $item->student?->codigo . ' — ' . $item->student?->nombre . ' — ' . \Carbon\Carbon::parse($item->fecha)->format('d/m/Y'),
                LateArrivalResource::class
            ),
            Text::make('Tipo', 'tipo'),
            Switcher::make('Aprobada', 'aprobada'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make('Llegada Tarde', 'lateArrival',
                    fn($item) => $item->student?->nombre . ' — ' . \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') . ' (' . $item->motivo . ')',
                    LateArrivalResource::class
                )->required()->searchable(),
                Select::make('Tipo', 'tipo')->options([
                    'Medica'     => 'Médica',
                    'Familiar'   => 'Familiar',
                    'Transporte' => 'Transporte',
                    'Otro'       => 'Otro',
                ])->required(),
                Textarea::make('Descripción', 'descripcion')->placeholder('Detalle de la excusa...'),
                Text::make('Archivo', 'archivo')->placeholder('Nombre del archivo adjunto'),
                Switcher::make('Aprobada', 'aprobada'),
            ]),
        ];
    }

    protected function detailFields(): iterable { return $this->formFields(); }
    public function search(): array { return ['tipo', 'descripcion']; }
}