<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

class DeleteModuleAction
{
    public function __construct(
        private readonly ModuleManagerService $modules
    ) {}

    public function execute(string $moduleName): void
    {
        $this->modules->delete($moduleName);
    }
}
