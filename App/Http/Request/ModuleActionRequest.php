<?php

namespace Modules\ModuleManager\App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ModuleActionRequest extends FormRequest
{
    private const string ROUTE_MODULE = 'module';

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [];
    }

    public function moduleName(): string
    {
        return (string) $this->route(self::ROUTE_MODULE);
    }
}
