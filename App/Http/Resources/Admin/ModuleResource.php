<?php

namespace Modules\ModuleManager\App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON representation of a migraine attack for API responses.
 *
 * @mixin ModuleResource
 */
class ModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this['name'],
            'alias' => $this['alias'],
            'enabled' => $this['enabled'],
            'path' => $this['path'],
            'version' => $this['version'],
            'description' => $this['description'] ?? null,
            'admin_actions' => $this['admin_actions'] ?? [],
        ];
    }
}
