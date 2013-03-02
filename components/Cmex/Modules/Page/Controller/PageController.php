<?php

namespace Cmex\Modules\Page\Controller;

use BaseController, ChunkManager, Authentication, Asset, Config, View;
use App;

use Cmex\Modules\Page\Model\Page;

class PageController extends BaseController {
    /**
     * handlePageRequest
     * Looks the page up in the database, loads chunks etc.
     * pretty much the most important method :D 
     * 
     * @param mixed $page 
     * @access public
     * @return void
     */
    public function handlePageRequest($page) {

        $template = Config::get('cmex.template');

        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if(!is_null($dbpage)) {

            // Inject the page into the ChunkManager
            ChunkManager::setPage($dbpage);

    	    // Load admin styles if authenticated
            // That's indeed really dirty, it has to be replaced later on...
            if(Authentication::check()) {
                Asset::add('adminstyle', 'admin/frontendstyle.css');
                Asset::add('jquery', 'admin/jquery-1.7.1.min.js');
                Asset::add('jquery-ui', 'admin/jquery-ui-1.8.18.custom.min.js');
                Asset::add('underscore', 'admin/underscore-min.js');
                Asset::add('backbone', 'admin/backbone-min.js');
                Asset::add('vie', 'admin/vie-min.js');

                Asset::add('jqtagsinput', 'admin/jquery.tagsinput.min.js');
                
                Asset::add('rangy', 'admin/rangy-core-1.2.3.js');
                Asset::add('hallo', 'admin/hallo-min.js');
                Asset::add('create', 'admin/create-min.js');
                Asset::add('frontendapp', 'admin/app.js');
                Asset::add('create-css', 'admin/create-ui/css/create-ui.css');
                Asset::add('create-notifications', 'admin/midgard-notifications/midgardnotif.css');
                Asset::add('font-awesome', 'admin/font-awesome/css/font-awesome.css');
                Asset::add('insertimage', 'admin/insertimage.css');
                Asset::add('valed', 'admin/create.ValueEditor.js');
            }

    	    // Load view
            $view = View::make($template.'.'.$dbpage->template, array(
                'page' => $page, 
                'title' => $dbpage->title
            ));

            return ChunkManager::renderChunks($view);
        }

        App::abort(404);
    }

    public function showHomePage() {
        $homepage = Config::get('cmex.homepage');
        if($homepage instanceof Illuminate\Http\RedirectResponse) {
            return $homepage;
        }

        return $this->handlePageRequest($homepage);
    }
}
