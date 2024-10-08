<?php

namespace Modules\ModuleManager\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ModuleManagerServiceProvider extends ServiceProvider
{
	protected string $moduleName = 'ModuleManager';

	protected string $moduleNameLower = 'modulemanager';

	/**
	 * Boot the application events.
	 */
	public function boot(): void
	{
		$this->registerTranslations();
		$this->registerConfig();
		$this->registerViews();
		$this->loadMigrationsFrom(module_path($this->moduleName, 'Database/migrations'));
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', $this->moduleNameLower);
	}

	/**
	 * Register the service provider.
	 */
	public function register(): void
	{
		$this->app->register(RouteServiceProvider::class);
	}

	/**
	 * Register translations.
	 */
	public function registerTranslations(): void
	{
		$moduleLangPath = module_path($this->moduleName, 'lang');

		if (is_dir($moduleLangPath)) {
			$this->loadTranslationsFrom($moduleLangPath, $this->moduleNameLower);
		}
	}

	/**
	 * Register config.
	 */
	protected function registerConfig(): void
	{
		$this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
		$this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
	}

	/**
	 * Register views.
	 */
	public function registerViews(): void
	{
		$viewPath = resource_path('views/modules/'.$this->moduleNameLower);
		$sourcePath = module_path($this->moduleName, 'resources/views');

		$this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

		$this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

		$componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
		Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
	}

	/**
	 * Get the services provided by the provider.
	 */
	public function provides(): array
	{
		return [];
	}

	private function getPublishableViewPaths(): array
	{
		$paths = [];
		foreach (config('view.paths') as $path) {
			if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
				$paths[] = $path.'/modules/'.$this->moduleNameLower;
			}
		}

		return $paths;
	}
}
