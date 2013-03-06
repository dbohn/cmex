<?php

namespace Cmex\Libraries\Installer;

abstract class ModuleSetup implements SetupableInterface {
    public abstract function install();

    public abstract function update($installedVersion);

    public abstract function uninstall();
}