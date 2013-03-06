<?php

namespace Cmex\Libraries\Installer;

interface SetupableInterface {
    public function install();

    public function update($installedVersion);

    public function uninstall();
}