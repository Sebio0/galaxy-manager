<?php

namespace Modules\System\Filament\Clusters\System\Resources\DeployKeyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\System\Filament\Clusters\System\Resources\DeployKeyResource;

class EditDeployKey extends EditRecord
{
    protected static string $resource = DeployKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
