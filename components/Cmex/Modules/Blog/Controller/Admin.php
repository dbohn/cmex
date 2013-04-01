<?php

namespace Cmex\Modules\Blog\Controller;

use Cmex\Modules\Admin\Controller\AdminController;

class Admin extends AdminController
{
    public function getIndex()
    {
        return \View::make('Blog::admin');
    }
}