<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

class DisableModuleAction
{
    public function __construct(
        private readonly ModuleManagerService $modules
    ) {}

    public function execute(string $moduleName): array
    {
        return $this->modules->disable($moduleName);
    }
}
