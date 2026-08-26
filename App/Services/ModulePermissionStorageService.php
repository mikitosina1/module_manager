<?php

namespace Modules\ModuleManager\App\Services;

use App\Contracts\ModulePermissionStorage;
use Modules\ModuleManager\App\Models\ModuleSettings;

final class ModulePermissionStorageService implements ModulePermissionStorage
{
    /**
     * @param string $module
     * @param int $roleId
     * @param string $permission
     * @return bool
     */
    public function allows(
        string $module,
        int $roleId,
        string $permission,
    ): bool {
        $settings = ModuleSettings::query()
            ->where('module_id', $module)
            ->first();

        if ($settings === null) {
            return false;
        }

        $permissions = $settings->getSettings()['permissions'] ?? [];

        return (bool) (
            $permissions[(string) $roleId][$permission]
            ?? false
        );
    }
}
