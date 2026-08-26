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

    public static function defaults(): array
    {
        return [
            config('roles.admin') => [
                'access' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'delete' => true,
            ],

            config('roles.user') => [
                'access' => true,
                'view' => true,
                'create' => false,
                'update' => false,
                'delete' => false,
            ],
        ];
    }
}
