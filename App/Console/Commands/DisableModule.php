<?php
/**
 * DisableModule
 * ---------------------------------------------------------------------------------------------------------------------
 * Disables module with console command
 */
namespace Modules\ModuleManager\App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class DisableModule extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'module:disable {module}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Disable a module';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
		$moduleName = $this->argument('module');
		$module = Module::find($moduleName);

		if ($module) {
			$module->disable();
			$this->info("Module {$moduleName} has been disabled.");
		} else {
			$this->error("Module {$moduleName} not found.");
		}
	}
}
