<?php

namespace Modules\System\Filament\Clusters;

use Filament\Clusters\Cluster;
use Nwidart\Modules\Facades\Module;

class System extends Cluster
{
    public static function getModule(): \Nwidart\Modules\Module
    {
        return Module::findOrFail(static::getModuleName());
    }

    public static function getModuleName(): string
    {
        return 'System';
    }

    public static function getNavigationLabel(): string
    {
        return __('System');
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-squares-2x2';
    }
}
