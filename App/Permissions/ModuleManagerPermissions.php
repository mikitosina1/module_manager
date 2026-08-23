<?php

namespace Modules\ModuleManager\App\Permissions;

use App\Contracts\ModulePermissions;

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