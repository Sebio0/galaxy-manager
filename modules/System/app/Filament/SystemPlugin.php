<?php

namespace Modules\System\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SystemPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'System';
    }

    public function getId(): string
    {
        return 'system';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
