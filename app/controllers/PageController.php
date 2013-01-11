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
        
        Event::listen('Load chunk', function($event) {
            return $event->scope . '_' . $event->name . ' wurde geladen!<br />';
        });

        $template = $conf['template'];
        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if(!is_null($dbpage)) {
    	    // Load admin styles if authenticated
            if(Auth::check()) {
                Asset::add('adminstyle', 'admin/style.css');
                Asset::add('requirejs', 'http://requirejs.org/docs/release/2.1.2/minified/require.js', array('data-main' => 'admin/app.js'));
            }

    	    // Load view
            $view = View::make($template.'.'.$dbpage->template, array(
                'head' => '__head__',
                'scripts' => '__scripts__', 
                'page' => $page, 
                'title' => $dbpage->title
            ))->render();

    	    // Insert Assets and other head elements
    	    $view = str_replace('__scripts__', Asset::getScripts(), $view);
            $view = str_replace('__head__', Asset::getStylesheets(), $view);

            return $view;
        }
        // TODO: Better Page not found handling!
        //return Response::error('404');
        return "Seite nicht gefunden: ". $page;
    }

    public function showHomePage() {
        $conf = Config::get('cmex');
        if($conf['homepage'] instanceof Illuminate\Http\RedirectResponse) {
            return $conf['homepage'];
        }

        return $this->handlePageRequest($conf['homepage']);
    }
}
