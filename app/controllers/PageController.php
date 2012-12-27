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
        // TODO: Change this to a config lookup
        $template = "default";

        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if(!is_null($dbpage)) {
    	    // Load admin styles if authenticated
            if(Auth::check()) {
                Asset::add('adminstyle', 'admin/style.css');
            }

    	    // Load view
            $view = View::make($template.'/'.$dbpage->template, array(
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
        // TODO: Homepage should not only be the page with identifier "home", add this to config...
        return $this->handlePageRequest("home");
    }
}
