<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModuleRefreshCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'module:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refreshs module list';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$modulebase = __DIR__ . '/../../components/modules/';

		$dirscan = scandir($modulebase);

		$modules = array();

		foreach($dirscan as $dir) {
			if (is_dir($modulebase . $dir) && $dir[0] != "." && file_exists($modulebase . $dir . "/routes.php")) {
				$modules[] = $dir;
			}
		}
		
		$path = __DIR__ . "/../storage/meta/modules.json";
		file_put_contents($path, json_encode($modules));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}