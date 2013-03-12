<?php

namespace Cmex\Modules\Admin\Controller;

use Cmex\Modules\Page\Model\Page;
use Request;
use Redirect;

class Frontend extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        // Only handle AJAX-Requests
        $this->beforeFilter(
            function () {
                if (!Request::ajax()) {
                    return Redirect::to('admin');
                }
            }
        );
    }
    // This is an AJAX-only controller, which needs admin
    // permissions so we want to utilize the AdminController
    // but don't need the layout view!
    protected $layout = null;

    public function getPages()
    {
        return Page::all();
    }

    public function getPage($page)
    {
        return Page::where('identifier', '=', $page)->take(1)->get();
    }
}
