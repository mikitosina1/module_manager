<?php

namespace Modules\ModuleManager\App\Permissions;

use App\Contracts\ModulePermissions;
use Modules\ModuleManager\App\Services\ModulePermissionService;

/**
 * @see ModulePermissionService
 */
final class ModuleManagerPermissions implements ModulePermissions
{
    public static function all(): array
    {
        return [
            'access',
            'view',
            'create',
            'update',
            'delete',
        ];
    }
}