<?php

namespace Modules\ModuleManager\App\Services;

use Modules\ModuleManager\App\Models\ModuleSettings;

class ModuleSettingsService
{
    public function get(string $moduleId): ModuleSettings
    {
        return ModuleSettings::firstOrCreate(
            ['module_id' => $moduleId],
            ['settings' => []],
        );
    }

    public function update(string $moduleId, array $settings): ModuleSettings
    {
        $moduleSettings = $this->get($moduleId);

        $moduleSettings->update([
            'settings' => $settings,
        ]);

        return $moduleSettings->refresh();
    }

    public function delete(string $moduleId): void
    {
        ModuleSettings::where('module_id', $moduleId)->delete();
    }
}