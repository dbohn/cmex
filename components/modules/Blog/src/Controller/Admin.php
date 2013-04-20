<?php

namespace Cmex\Modules\Blog\Controller;

use Cmex\Libraries\System\AdminController;

class Admin extends AdminController
{
    public function getIndex()
    {
        return \View::make('Blog::admin');
    }
}
