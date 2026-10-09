<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\LateArrival\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\Contracts\UI\ActionButtonContract;

class LateArrivalIndexPage extends IndexPage
{
    protected function topRightButtons(): ListOf
    {
        $buttons = parent::topRightButtons()->toArray();

        /** @var \App\Models\MoonshineUser|null $user */
        $user = auth()->guard('moonshine')->user();

        if ($user && ($user->isAdmin() || $user->isCoordinador())) {
            $buttons[] = ActionButton::make('Excel', route('exports.late-arrivals.excel'))
                ->icon('table-cells');

            $buttons[] = ActionButton::make('PDF', route('exports.late-arrivals.pdf'))
                ->icon('document-arrow-down');
        }

        return new ListOf(ActionButtonContract::class, $buttons);
    }
}