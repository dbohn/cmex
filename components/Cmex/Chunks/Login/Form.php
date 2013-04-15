<?php

namespace Cmex\Chunks\Login;

use Cmex\Libraries\Chunks\Chunk;

class Form extends Chunk
{

    public function show()
    {
        $content = json_decode($this->content);
        $view = 'Chunks/Login::loginformview';
        if (isset($content->view)) {
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
