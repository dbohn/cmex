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
                Asset::add('requirejs', 'http://requirejs.org/docs/release/2.1.2/minified/require.js', array('data-main' => 'admin/app.js'));
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
