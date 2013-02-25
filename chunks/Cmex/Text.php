<?php
namespace Chunks\Cmex;
use Chunks\Cmex\Search\SearchableInterface;

/**
* cmex! Standard Text
* 
* @version 1.0
* @author David Bohn
* @copyright 2013 cmex! Team
*/
class Text extends \Chunk implements SearchableInterface {
    public function config() {
        return "";
    }

    public function getIndex() {
        return $this->content;
    }

    public function show($properties=array()) {
        $_ = $this;
        // TODO: The cache should be refreshed when the updated_at flag
        // is behind the cache-date!
        $value = \Cache::remember($this->identifier, 10, function() use($_) {
            $v = \View::make("Cmex.textview", array(
                'content' => $_->content
            ));
            return $v->render();
        });
        //return $this->content;
        if(\Authentication::check())
        {
            return '<div property="text">' . $value . '</div>';
        }
        return $value;
    }

    public function handleInput($data) {
        return true;
    }

    public function annotate()
    {
        return array();
    }
}