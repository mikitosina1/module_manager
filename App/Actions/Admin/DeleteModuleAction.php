<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

readonly class DeleteModuleAction
{
    public function __construct(
        private ModuleManagerService $modules
    ) {}

    public function execute(string $moduleName): void
    {
        $this->modules->delete($moduleName);
    }
}
