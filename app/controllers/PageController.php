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
                Asset::add('alohacss', 'http://cdn.aloha-editor.org/latest/css/aloha.css');
                Asset::add('jquery', 'http://code.jquery.com/jquery-1.8.3.js');
                Asset::add('jquery-ui', 'http://code.jquery.com/ui/1.9.2/jquery-ui.js');
                Asset::add('requirejs', 'http://requirejs.org/docs/release/2.1.2/minified/require.js');
                Asset::add('aloha', 'http://cdn.aloha-editor.org/latest/lib/aloha.js');
                Asset::add('modernizr', 'http://modernizr.com/downloads/modernizr-latest.js');
                Asset::add('underscore', 'admin/underscore-min.js');
                Asset::add('backbone', 'admin/backbone-min.js');
                Asset::add('vie', 'admin/vie.js');
                Asset::add('create', 'admin/create.js');
                Asset::add('frontendapp', 'admin/app.js');
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
