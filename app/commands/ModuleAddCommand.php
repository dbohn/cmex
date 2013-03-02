<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ModuleAddCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'module:add';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Adds an existing module to the registered modules';

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
		$name = $this->argument('name');

		$modulebase = __DIR__ . '/../../components/Cmex/Modules/';

		if(is_dir($modulebase . $name)) {
			if(!is_dir($modulebase . $name . '/Controller')) {
				mkdir($base . $name . "/Controller");
				touch($base . $name . "/Controller/.gitkeep");
			}

			if(!is_dir($modulebase . $name . '/views')) {
				mkdir($base . $name . "/views");
				touch($base . $name . "/views/.gitkeep");
			}

			if(!is_dir($modulebase . $name . '/Model')) {
				mkdir($base . $name . "/Model");
				touch($base . $name . "/Model/.gitkeep");
			}

			if(!is_dir($modulebase . $name . '/config')) {
				mkdir($base . $name . "/config");
				touch($base . $name . "/config/.gitkeep");
			}

			if(!file_exists($modulebase . $name . '/routes.php')) {
				file_put_contents($base . $name . "/routes.php", "<?php\n //");
			}
		} else {
			$this->error("Module does not exist!");
			return;
		}

		$this->addToModuleList($name);

		$this->info("Module was successfully added!");
	}

	private function addToModuleList($name)
	{
		$path = __DIR__ . "/../storage/meta/modules.json";
		if(file_exists($path)) {
			$modules = json_decode(file_get_contents($path));
		} else {
			$modules = array();
		}

		if($modules === null) {
			$modules = array();
		}

		if(!in_array($name, $modules)) {
			$modules[] = $name;
		}

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
			array('name', InputArgument::REQUIRED, 'Name of the module that is to be added.'),
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