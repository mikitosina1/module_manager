<?php

namespace Modules\ModuleManager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function moduleName(): string
    {
        return $this->route('module');
    }

    public function rules(): array
    {
        return [];
    }
}