<?php

namespace Modules\ModuleManager\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetModulePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'array'],
            'permissions.*.*' => ['required', 'boolean'],
        ];
    }

    public function moduleName(): string
    {
        return (string) $this->route('module');
    }

    public function permissions(): array
    {
        return $this->validated('permissions');
    }
}