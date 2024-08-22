<?php

namespace Modules\ModuleManager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Nwidart\Modules\Facades\Module;

class ModuleManagerController extends Controller
{
	public function enable(Request $request): JsonResponse
	{
		$moduleName = $request->input('module');
		$module = Module::find($moduleName);

		if ($module) {
			$module->enable();
			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_enabled', ['module' => $moduleName])], 200);
		} else {
			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_not_found', ['module' => $moduleName])], 404);
		}
	}

	public function disable(Request $request): JsonResponse
	{
		$moduleName = $request->input('module');
		if ($moduleName != 'ModuleManager') {
			$module = Module::find($moduleName);

			if ($module) {
				$module->disable();
				return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_disabled', ['module' => $moduleName])], 200);
			} else {
				return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_not_found', ['module' => $moduleName])], 404);
			}
		} else {
			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_cant_disabled', ['module' => $moduleName])], 200);
		}
	}
}
