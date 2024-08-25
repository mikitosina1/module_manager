<?php

namespace Modules\ModuleManager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

	public function delete(Request $request): JsonResponse
	{
		$moduleName = $request->input('module');

		$modulePath = base_path('Modules/' . $moduleName);
		if (!is_dir($modulePath)) {
			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_not_found', ['module' => $moduleName])], 404);
		}

		try {
			$this->deleteDirectory($modulePath);
			// Clear Cache
			Artisan::call('config:clear');
			Artisan::call('cache:clear');
			Artisan::call('config:cache');
			Artisan::call('optimize:clear');

			// composer dump-autoload
			exec('/usr/local/bin/composer dump-autoload', $output, $return_var);
			if ($return_var !== 0) {
				throw new \Exception('Failed to execute composer dump-autoload: ' . implode("\n", $output));
			}

			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.module_deleted', ['module' => $moduleName])], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => Lang::get('modulemanager::module_manager_lang.problem_delete_module', ['module' => $moduleName])], 500);
		}
	}

	protected function deleteDirectory($dir): void
	{
		if (!file_exists($dir)) {
			return;
		}

		$files = array_diff(scandir($dir), ['.', '..']);

		foreach ($files as $file) {
			$filePath = "$dir/$file";
			(is_dir($filePath)) ? $this->deleteDirectory($filePath) : unlink($filePath);
		}

		rmdir($dir);
	}

}
