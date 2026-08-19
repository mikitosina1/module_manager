<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

readonly class GetModuleSettingsAction
{
    public function __construct(
        private ModuleManagerService $modules
    ) {}

    public function execute(string $moduleName): array
    {
        return $this->modules->getSettings($moduleName);
    }
}