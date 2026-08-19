<?php

namespace Modules\ModuleManager\App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static self firstOrCreate(array $attributes = [], array $values = [])
 * @method static self where($column, $operator = null, $value = null, $boolean = 'and')
 */
class ModuleSettings extends Model
{
    protected $fillable = [
        'module_id',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}