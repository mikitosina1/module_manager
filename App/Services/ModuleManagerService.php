<?php

namespace Modules\ModuleManager\App\Services;

use App\Models\Role;
use App\Services\ModulePermissionService;
use App\Services\ModuleSettingsInitializer;
use App\Services\ModuleSettingsService;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;

class ModuleManagerService
{
    private const array PROTECTED_MODULES = [
        'ModuleManager',
    ];

    public function __construct(
        private readonly ModuleCacheService      $cache,
        private readonly ModuleSettingsService   $settings,
        private readonly ModuleSettingsInitializer $initializer,
        private readonly ModulePermissionService $permissions,
    ) {}

    public function list(): array
    {
        return collect(Module::all())
            ->map(fn ($module) => [
                'id' => $module->get('id'),
                'name' => $module->getName(),
                'alias' => $module->get('alias'),
                'enabled' => $module->isEnabled(),
                'path' => $module->getPath(),
                'version' => $module->get('version'),
                'description' => $module->getDescription(),
                'admin_actions' => ModuleAdminActionRegistrar::getActions(
                    $module->getName()
                ),
            ])
            ->toArray();
    }

    public function enable(string $moduleName): array
    {
        $module = $this->findOrFail($moduleName);
        $module->enable();

        return $this->toArray($module);
    }

    public function disable(string $moduleName): array
    {
        $this->ensureNotProtected($moduleName);

        $module = $this->findOrFail($moduleName);
        $module->disable();

        return $this->toArray($module);
    }

    public function delete(string $moduleName): void
    {
        $this->ensureNotProtected($moduleName);

        $module = $this->findOrFail($moduleName);

        $module->delete();

        $this->cache->clear();
    }

    public function setAccess(
        string $moduleName,
        array $permissions
    ): void {
        $module = $this->findOrFail($moduleName);

        $moduleId = $this->moduleId($module);
        $this->initializer->initialize($module->getName(), $moduleId);

        $availablePermissions = $this->permissions->get(
            $module->getName()
        );

        $normalizedPermissions = [];

        foreach ($permissions as $roleId => $rolePermissions) {
            foreach ($availablePermissions as $permission) {
                $normalizedPermissions[$roleId][$permission] =
                    (bool) ($rolePermissions[$permission] ?? false);
            }
        }

        $settings = $this->settings->get($moduleId);
        $current = $settings->getSettings();

        $current['permissions'] = $normalizedPermissions;

        $this->settings->update($moduleId, $current);
    }

    public function getSettings(
        string $moduleName
    ): array {
        $module = $this->findOrFail($moduleName);
        $moduleId = $this->moduleId($module);

        $this->initializer->initialize($module->getName(), $moduleId);

        $settings = $this->settings->get($moduleId);

        $storedPermissions = $settings->getSettings()['permissions'] ?? [];

        $availablePermissions = $this->permissions->get(
            $module->getName()
        );

        return [
            'module' => [
                'id' => $moduleId,
                'name' => $module->getName(),
                'alias' => $module->get('alias'),
            ],

            'permissions' => $availablePermissions,

            'roles' => Role::query()
                ->select(['id', 'title'])
                ->get()
                ->map(function (Role $role) use (
                    $storedPermissions,
                    $availablePermissions
                ) {
                    $rolePermissions = $storedPermissions[$role->id] ?? [];

                    return [
                        'id' => $role->id,
                        'name' => $role->title,
                        'permissions' => collect($availablePermissions)
                            ->mapWithKeys(fn (string $permission) => [
                                $permission => $rolePermissions[$permission] ?? false,
                            ])
                            ->all(),
                    ];
                })
                ->values()
                ->all(),
        ];
    }

    private function moduleId(LaravelModule $module): string
    {
        return $module->get('id') ?? $module->getLowerName();
    }

    private function findOrFail(
        string $moduleName
    ): LaravelModule {
        $module = Module::find($moduleName);

        if (! $module) {
            abort(404, __('modulemanager::module_manager_lang.module_not_found', [
                'module' => $moduleName,
            ]));
        }

        return $module;
    }

    private function toArray(
        LaravelModule $module
    ): array {
        return [
            'id' => $module->get('id') ?? $module->getLowerName(),
            'name' => $module->getName(),
            'alias' => $module->get('alias'),
            'enabled' => $module->isEnabled(),
            'path' => $module->getPath(),
            'version' => $module->get('version'),
            'description' => $module->getDescription(),
            'admin_actions' => ModuleAdminActionRegistrar::getActions($module->getName()),
        ];
    }

    private function ensureNotProtected(
        string $moduleName
    ): void {
        if (in_array($moduleName, self::PROTECTED_MODULES, true)) {
            abort(403, __('modulemanager::module_manager_lang.module_cant_disabled', [
                'module' => $moduleName,
            ]));
        }
    }
}
