<?php
/**
 * EnableModule
 * ---------------------------------------------------------------------------------------------------------------------
 * Enables module with console command
 */
namespace Modules\ModuleManager\App\Console\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;

class EnableModule extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'module:enable  {module}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Enabling installed module.';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
		$moduleName = $this->argument('module');
		$module = Module::find($moduleName);

		if ($module) {
			$module->enable();
			$this->info("Module {$moduleName} has been enabled.");
		} else {
			$this->error("Module {$moduleName} not found.");
		}
	}
}
