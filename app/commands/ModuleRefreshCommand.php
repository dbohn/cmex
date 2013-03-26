<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Cmex\Libraries\Installer\ModuleListCreator;

class ModuleRefreshCommand extends Command
{

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

        $path = storage_path() . '/meta/modules.json';

        $this->mlc->setModuleBase($modulebase);
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
