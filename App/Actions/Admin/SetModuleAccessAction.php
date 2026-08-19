<?php

namespace Modules\ModuleManager\App\Actions\Admin;

use Modules\ModuleManager\App\Services\ModuleManagerService;

readonly class SetModuleAccessAction
{
    public function __construct(
        private ModuleManagerService $modules
    ) {}

    public function execute(
        string $moduleName,
        array $permissions
    ): void {
        $this->modules->setAccess($moduleName, $permissions);
    }
}