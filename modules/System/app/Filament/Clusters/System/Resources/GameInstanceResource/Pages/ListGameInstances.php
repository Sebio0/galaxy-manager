<?php

namespace Modules\System\Filament\Clusters\System\Resources\GameInstanceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\System\Filament\Clusters\System\Resources\GameInstanceResource;

class ListGameInstances extends ListRecords
{
    protected static string $resource = GameInstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
