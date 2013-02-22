<?php

namespace Chunks\Cmex\Login;

class Form extends \Chunk {
    public function config()
    {
        return "";
    }

    public function show()
    {
        $content = json_decode($this->content);
        $view = 'Cmex.Login.views.loginformview';
        if (isset($content->view))
        {
            $view = $content->view;
        }
        return \View::make($view);
    }

    public function handleInput($data)
    {

    }

    public function annotate()
    {

    }
}