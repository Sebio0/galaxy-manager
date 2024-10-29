<?php

namespace Modules\System\Filament\Clusters\System\Resources\DeployKeyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\System\Filament\Clusters\System\Resources\DeployKeyResource;

class ListDeployKeys extends ListRecords
{
    protected static string $resource = DeployKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
