<?php

class PageController extends BaseController {
    public function handlePageRequest($page) {
        // Add CSRF Token to all fields!
        Form::include_all(function()
        {
            return Form::template('div',function($form)
            {
                $form->hidden('csrf_token')->value(Session::getToken());
                $form->setClass('token');
            });
        });

        $template = "default";
        // Look up page in database
        $dbpage = Page::where('identifier', $page)->first();
        if(!is_null($dbpage)) {
            
            return View::make($template.'/'.$dbpage->template)->with(array('head' => '', 'scripts' => 'Hallo1', 'page' => $page, 'title' => $dbpage->title));
        }
        //return Response::error('404');
        return "Seite nicht gefunden: ". $page;
    }

    public function showHomePage() {
        return $this->handlePageRequest("home");
    }
}