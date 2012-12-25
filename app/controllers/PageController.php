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
            View::composer($template.'/'.$dbpage->template, function($view) use($page, $dbpage) {
                    $view['head'] = "";
                    $view['scripts'] = "";
                    $view['page'] = $page;
                    $view['title'] = $dbpage->title;
            });
            Event::listen('laravel.done', function($response) {
                echo "Laravel done!";
                //return $response;
            });
            return View::make($template.'/'.$dbpage->template);
        }
        //return Response::error('404');
        return "Seite nicht gefunden: ". $page;
    }

    public function showHomePage() {
        return $this->handlePageRequest("home");
    }
}