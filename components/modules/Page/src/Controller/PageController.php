<?php

namespace Cmex\Modules\Page\Controller;

use Cmex\Libraries\System\FrontendController;
use ChunkManager;
use Authentication;
use Asset;
use Config;
use View;
use App;
use Meta;

use Cmex\Modules\Page\Model\Page;

class PageController extends FrontendController
{

    /**
     * handlePageRequest
     * Looks the page up in the database, loads chunks etc.
     * pretty much the most important method :D 
     * 
     * @param mixed $page 
     * @access public
     * @return void
     */
    public function handlePageRequest($page)
    {

        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if (!is_null($dbpage)) {
            // If site is not live, only admins or superuser are allowed to view the page
            // That should be changed later as this should be more customisable
            // but we need the working right system first
            if ($dbpage->status !== 'live' && !(Authentication::check() && (Authentication::getUser()->inGroup(Authentication::getGroupProvider()->findByName('Administrator')) || Authentication::getUser()->isSuperUser()))) {
                App::abort(404);
            }
            $this->setPageIdentifier($page);

            if (Authentication::check()) {
                Asset::add('ckeditor', 'assets/js/admin/frontend/ckeditor/ckeditor.js');
                Asset::add(
                    'frontend',
                    'assets/js/admin/frontend/dependencies/require.js',
                    array(
                        "data-main" => asset('assets/js/admin/frontend/frontend.js')
                    )
                );
                Asset::add('frontendstyle', 'assets/js/admin/frontend/style.css');

                Meta::element(
                    'script',
                    array('type' => 'text/javascript'),
                    'window.cmexPage = ' . $dbpage->toJson()
                );
            }

            // Load view
            return View::make(
                $this->template.'.'.$dbpage->template,
                array(
                    'page' => $page,
                    'title' => $dbpage->title
                )
            );
        }

        App::abort(404);
    }

    public function showHomePage()
    {
        $homepage = Config::get('cmex.homepage');

        if ($homepage instanceof \Closure) {
            $homepage = $homepage();
        }

        if ($homepage instanceof \Illuminate\Http\RedirectResponse) {
            return $homepage;
        }

        return $this->handlePageRequest($homepage);
    }
}
