<?php

namespace Cmex\Libraries\Installer;

abstract class ModuleSetup implements SetupableInterface
{
    abstract public function install();

    abstract public function update($installedVersion);

    abstract public function uninstall();
}
