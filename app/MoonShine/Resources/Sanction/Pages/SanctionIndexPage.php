<?php
declare(strict_types=1);
namespace App\MoonShine\Resources\Sanction\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\Contracts\UI\ActionButtonContract;

class SanctionIndexPage extends IndexPage
{
    protected function topRightButtons(): ListOf
    {
        $buttons = parent::topRightButtons()->toArray();

        /** @var \App\Models\MoonshineUser|null $user */
        $user = auth()->guard('moonshine')->user();

        if ($user && ($user->isAdmin() || $user->isCoordinador())) {
            $buttons[] = ActionButton::make('Excel', route('exports.sanctions.excel'))
                ->icon('table-cells');

            $buttons[] = ActionButton::make('PDF', route('exports.sanctions.pdf'))
                ->icon('document-arrow-down');
        }

        return new ListOf(ActionButtonContract::class, $buttons);
    }
}