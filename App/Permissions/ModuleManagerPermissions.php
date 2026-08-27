<?php

namespace Modules\ModuleManager\App\Permissions;

use App\Contracts\ModulePermissions;
use App\Models\Role;
use App\Services\ModulePermissionService;

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
            Role::ADMIN => [
                'access' => true,
                'view' => true,
                'create' => true,
                'update' => true,
                'delete' => true,
            ],

            Role::USER => [
                'access' => true,
                'view' => true,
                'create' => false,
                'update' => false,
                'delete' => false,
            ],
        ];
    }
}
