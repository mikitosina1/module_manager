<?php

namespace Modules\ModuleManager\App\Services;

use Illuminate\Support\Facades\Artisan;

class ModuleCacheService
{
    public function clear(): void
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');
    }
}
