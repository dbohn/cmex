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

            if(Authentication::check()) {
                Asset::add('ckeditor', 'admin/frontend/ckeditor.js');
                Asset::add('frontend', 'admin/frontend/dependencies/require.js', array("data-main" => asset('admin/frontend/frontend.js')));
                Asset::add('frontendstyle', 'admin/frontend/style.css');
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

        if($homepage instanceof \Closure) {
            $homepage = $homepage();
        }

        if($homepage instanceof \Illuminate\Http\RedirectResponse) {
            return $homepage;
        }

        return $this->handlePageRequest($homepage);
    }
}