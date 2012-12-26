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
            if(Auth::check()) {
                Asset::add('adminstyle', 'admin/style.css');
            }

            $view = View::make($template.'/'.$dbpage->template, array(
                'head' => '__head__',
                'scripts' => '__scripts__', 
                'page' => $page, 
                'title' => $dbpage->title
                ))->render();
            $view = str_replace('__scripts__', Asset::getScripts(), $view);
            $view = str_replace('__head__', Asset::getStylesheets(), $view);

            return $view;
        }
        //return Response::error('404');
        return "Seite nicht gefunden: ". $page;
    }

    public function showHomePage() {
        return $this->handlePageRequest("home");
    }
}