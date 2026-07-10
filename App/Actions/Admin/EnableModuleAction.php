<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

class EnableModuleAction
{
    public function __construct(
        private readonly ModuleManagerService $modules
    ) {}

    public function execute(string $moduleName): array
    {
        return $this->modules->enable($moduleName);
    }
}
