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

    public function getPages()
    {
        return Page::all();
    }

    public function getPage($page)
    {
        if (is_numeric($page)) {
            return Page::where('id', '=', $page)->first();
        }
        return Page::where('identifier', '=', $page)->first();
    }

    public function getTemplateList()
    {
        $theme = Config::get('cmex.template');

        $this->finder->files()->in(app_path() . "/../public/templates/" . $theme)->name('*.twig')->depth('== 0');

        $templates = array();

        foreach ($this->finder as $file) {
            $templatename = str_replace('.twig', '', $file->getFilename());
            $templates[] = array("id" => $templatename, "name" => $templatename ." Template");
        }

        return Response::json($templates);
    }
}
