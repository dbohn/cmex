<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Cmex\Libraries\Installer\ModuleListCreator;

class ModuleAddCommand extends Command
{

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

    private $mlc = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ModuleListCreator $mlc)
    {
        $this->mlc = $mlc;
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
        $path = storage_path() . '/meta/modules.json';

        if (is_dir($modulebase . $name)) {
            if (!is_dir($modulebase . $name . '/Controller')) {
                mkdir($base . $name . "/Controller");
                touch($base . $name . "/Controller/.gitkeep");
            }

            if (!is_dir($modulebase . $name . '/views')) {
                mkdir($base . $name . "/views");
                touch($base . $name . "/views/.gitkeep");
            }

            if (!is_dir($modulebase . $name . '/Model')) {
                mkdir($base . $name . "/Model");
                touch($base . $name . "/Model/.gitkeep");
            }

            if (!is_dir($modulebase . $name . '/config')) {
                mkdir($base . $name . "/config");
                touch($base . $name . "/config/.gitkeep");
            }

            if (!file_exists($modulebase . $name . '/routes.php')) {
                file_put_contents($base . $name . "/routes.php", "<?php\n //");
            }

            if (!file_exists($modulebase . $name . '/info.php')) {
                file_put_contents($base . $name . "/info.php", "<?php\n return array();");
            }
        } else {
            $this->error("Module does not exist!");
            return;
        }

        $this->mlc->setModuleBase($modulebase);
        $this->mlc->setStorage($path);

        $this->mlc->updateModuleList();

        //$this->addToModuleList($name);

        $this->info("Module was successfully added!");
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
