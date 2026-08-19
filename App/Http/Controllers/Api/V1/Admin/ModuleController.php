<?php

namespace Modules\ModuleManager\App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\ModuleManager\App\Actions\Admin\DeleteModuleAction;
use Modules\ModuleManager\App\Actions\Admin\DisableModuleAction;
use Modules\ModuleManager\App\Actions\Admin\EnableModuleAction;
use Modules\ModuleManager\App\Actions\Admin\GetModuleSettingsAction;
use Modules\ModuleManager\App\Actions\Admin\SetModuleAccessAction;
use Modules\ModuleManager\App\Http\Requests\ModuleActionRequest;
use Modules\ModuleManager\App\Http\Requests\ModuleSettingsRequest;
use Modules\ModuleManager\App\Http\Requests\SetModuleAccessRequest;
use Modules\ModuleManager\App\Http\Resources\Admin\ModuleResource;
use Modules\ModuleManager\App\Services\ModuleManagerService;
use Nwidart\Modules\Laravel\Module;

class ModuleController extends Controller
{
    public function index(
        ModuleManagerService $service
    ): AnonymousResourceCollection {
        return ModuleResource::collection(
            $service->list()
        );
    }

    public function enable(
        ModuleActionRequest $request,
        EnableModuleAction $action
    ): JsonResponse {
        /** @var Module $module */
        $module = $action->execute($request->moduleName());

        return response()->json([
            'message' => __('modulemanager::module_manager_lang.module_enabled', [
                'module' => $module['name'],
            ]),
            'data' => new ModuleResource($module),
        ]);
    }

    public function disable(
        ModuleActionRequest $request,
        DisableModuleAction $action
    ): JsonResponse {
        $module = $action->execute($request->moduleName());

        return response()->json([
            'message' => __('modulemanager::module_manager_lang.module_disabled', [
                'module' => $module['name'],
            ]),
            'data' => new ModuleResource($module),
        ]);
    }

    public function destroy(
        ModuleActionRequest $request,
        DeleteModuleAction $action
    ): JsonResponse {
        $action->execute($request->moduleName());

        return response()->json([
            'message' => __('modulemanager::module_manager_lang.module_deleted', [
                'module' => $request->moduleName(),
            ]),
        ]);
    }

    public function getSettings(
        ModuleSettingsRequest $request,
        GetModuleSettingsAction $action
    ): JsonResponse {
        return response()->json([
            'data' => $action->execute($request->moduleName()),
        ]);
    }

    public function setAccess(
        SetModuleAccessRequest $request,
        SetModuleAccessAction $action
    ): JsonResponse {
        $action->execute(
            $request->moduleName(),
            $request->permissions(),
        );

        return response()->json([
            'message' => __('modulemanager::module_manager_lang.access_updated'),
        ]);
    }
}
