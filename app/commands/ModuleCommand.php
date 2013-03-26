<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Cmex\Libraries\Installer\ModuleListCreator;

class ModuleCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a cmex! module and registers it.';

    private $mlc;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ModuleListCreator $mlc)
    {
        parent::__construct();
        $this->mlc = $mlc;
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

        $this->info("Creating module " . $this->argument('name') . "...");

        if (is_dir($modulebase . $name) || file_exists($modulebase . $name)) {
            $this->error("Module could not be created because it already exists!");
            return;
        }

        $this->createModuleStructure($modulebase, $name);
        $this->addToModuleList($modulebase);

        $this->info("Module created successfully!");
    }

    private function createModuleStructure($base, $name)
    {
        // Create base directory
        mkdir($base . $name);

        // Create mvc directories
        mkdir($base . $name . "/Controller");
        touch($base . $name . "/Controller/.gitkeep");
        mkdir($base . $name . "/Model");
        touch($base . $name . "/Model/.gitkeep");
        mkdir($base . $name . "/views");
        touch($base . $name . "/views/.gitkeep");

        // Create config directory
        mkdir($base . $name . "/config");
        touch($base . $name . "/config/.gitkeep");

        file_put_contents($base . $name . "/routes.php", "<?php\n //");

        file_put_contents($base . $name . "/info.php", "<?php\n return array();");
    }

    private function addToModuleList($base)
    {
        $path = storage_path() . '/meta/modules.json';

        $this->mlc->setModuleBase($base);
        $this->mlc->setStorage($path);
        $this->mlc->updateModuleList();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'The name of the module.'),
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
