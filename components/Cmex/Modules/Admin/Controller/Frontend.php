<?php

namespace Cmex\Modules\Admin\Controller;

use Cmex\Modules\Page\Model\Page;

class Frontend extends AdminController
{
    // This is an AJAX-only controller, which needs admin
    // permissions so we want to utilize the AdminController
    // but don't need the layout view!
    protected $layout = null;

    public function getPages()
    {
        return Page::all();
    }
}
