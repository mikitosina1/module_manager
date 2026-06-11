<?php

namespace Modules\ModuleManager\App\Services;

class ModuleAdminActionRegistrar
{
    /** @var array<string, array<int, array{label:string, route:string, icon:string}>> */
    protected static array $actions = [];

    /**
     * Register new actions for the module in an admin panel.
     *
     * @param  string  $moduleName  Module name (ex. "MigraineDiary")
     * @param  string  $moduleNameLower  Module name in the lower register (ex. "migrainediary")
     * @param  string  $route  route name (ex. "migrainediary.admin.index")
     * @param  string  $label  label for the button (translatable)
     * @param  string  $icon  icon, emoji or HTML
     * @param  callable|null  $condition  Function, returning true/false, need button or not
     */
    public static function register(
        string $moduleName,
        string $moduleNameLower,
        string $route,
        string $label,
        string $icon,
        ?callable $condition = null
    ): void {
        if ($condition === null || $condition()) {
            if (! isset(self::$actions[$moduleName])) {
                self::$actions[$moduleName] = [];
            }

            self::$actions[$moduleName][] = [
                'label' => $label,
                'route' => $route,
                'icon' => $icon,
            ];
        }
    }

    /**
     * Return all registered action buttons.
     *
     * @return array<string, array<int, array{label:string, route:string, icon:string}>>
     */
    public static function getAllActions(): array
    {
        return self::$actions;
    }
}
