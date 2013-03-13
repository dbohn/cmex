<?php

namespace Cmex\Modules\Admin\Controller;

use Cmex\Modules\Page\Model\Page;
use Symfony\Component\Finder\Finder;
use Request;
use Redirect;
use Response;
use Config;

class Frontend extends AdminController
{
    private $finder = null;

    public function __construct(Finder $finder)
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

        $this->finder = $finder;
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

    public function getTemplateList()
    {
        $theme = Config::get('cmex.template');

        $this->finder->files()->in(app_path() . "/../public/templates/" . $theme)->name('*.twig')->depth('== 0');

        $templates = array();

        foreach ($this->finder as $file) {
            $templates[] = str_replace('.twig', '', $file->getFilename());
        }

        return Response::json($templates);
    }
}
