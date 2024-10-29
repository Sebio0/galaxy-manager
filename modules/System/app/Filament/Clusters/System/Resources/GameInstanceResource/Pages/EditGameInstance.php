<?php

namespace Modules\System\Filament\Clusters\System\Resources\GameInstanceResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\System\Filament\Clusters\System\Resources\GameInstanceResource;

class EditGameInstance extends EditRecord
{
    protected static string $resource = GameInstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
