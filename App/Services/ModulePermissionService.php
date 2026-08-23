<?php

namespace Modules\ModuleManager\App\Services;

use App\Contracts\ModulePermissions;

final class ModulePermissionService
{
    /**
     * @return array<string>
     */
    public function get(string $moduleName): array
    {
        $class = sprintf(
            'Modules\\%s\\App\\Permissions\\%sPermissions',
            $moduleName,
            $moduleName,
        );

        if (! class_exists($class)) {
            return [];
        }

        if (! is_subclass_of($class, ModulePermissions::class)) {
            return [];
        }

        return $class::all();
    }
}