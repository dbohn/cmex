<?php

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
        
        $conf = Config::get('cmex');

        $template = $conf['template'];

        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if(!is_null($dbpage)) {

            // Inject the page into the ChunkManager
            ChunkManager::setPage($dbpage);

    	    // Load admin styles if authenticated
            if(Authentication::check()) {
                Asset::add('adminstyle', 'admin/style.css');
                Asset::add('jquery', 'admin/jquery-1.7.1.min.js');
                Asset::add('jquery-ui', 'admin/jquery-ui-1.8.18.custom.min.js');
                Asset::add('underscore', 'admin/underscore-min.js');
                Asset::add('backbone', 'admin/backbone-min.js');
                Asset::add('vie', 'admin/vie-min.js');

                Asset::add('jqtagsinput', 'admin/jquery.tagsinput.min.js');
                Asset::add('jqrdfquery', 'admin/jquery.rdfquery.min.js');
                Asset::add('rangy', 'admin/rangy-core-1.2.3.js');
                Asset::add('hallo', 'admin/hallo-min.js');
                Asset::add('create', 'admin/create-min.js');
                Asset::add('frontendapp', 'admin/app.js');
                Asset::add('create-css', 'admin/create-ui/css/create-ui.css');
                Asset::add('create-notifications', 'admin/midgard-notifications/midgardnotif.css');
                Asset::add('font-awesome', 'admin/font-awesome/css/font-awesome.css');
                Asset::add('insertimage', 'admin/insertimage.css');
            }

    	    // Load view - with that step, all chunks are initialized
            $view = View::make($template.'.'.$dbpage->template, array(
                'head' => '__head__',
                'scripts' => '__scripts__', 
                'page' => $page, 
                'title' => $dbpage->title
            ))->render();

            ChunkManager::handleInput();

            foreach(ChunkManager::getLoadedChunks() as $chunk)
            {
                //echo $chunk;
                $view = str_replace('__'.$chunk.'__', ChunkManager::showForKey($chunk), $view);
            }

            // Insert Assets and other head elements
            $view = str_replace('__scripts__', Asset::getScripts(), $view);
            $view = str_replace('__head__', Asset::getStylesheets(), $view);

            return $view;
        }
        // TODO: Better Page not found handling!
        //return Response::error('404');
        App::abort(404);
        //return "Seite nicht gefunden: ". $page;
    }

    public function showHomePage() {
        $conf = Config::get('cmex');
        if($conf['homepage'] instanceof Illuminate\Http\RedirectResponse) {
            return $conf['homepage'];
        }

        return $this->handlePageRequest($conf['homepage']);
    }
}
