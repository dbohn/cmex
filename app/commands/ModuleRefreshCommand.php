<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Cmex\Libraries\Installer\ModuleListCreator;

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

	private $mlc = null;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ModuleListCreator $mlist)
	{
		parent::__construct();

		$this->mlc = $mlist;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$modulebase = __DIR__ . '/../../components/Cmex/Modules/';
		$path = __DIR__ . "/../storage";

		$this->mlc->setModuleBase($modulebase);
		$this->mlc->setStorage($path);

		$this->mlc->updateModuleList();

		// $dirscan = scandir($modulebase);

		// $modules = array();

		// foreach($dirscan as $dir) {
		// 	if (is_dir($modulebase . $dir) && $dir[0] != "." && file_exists($modulebase . $dir . "/routes.php")) {
		// 		$modules[] = $dir;
		// 	}
		// }
		
		
		// file_put_contents($path, json_encode($modules));
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