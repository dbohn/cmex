<?php
namespace Cmex\Chunks\Text;

use Cmex\Chunks\Search\SearchableInterface;
use Cmex\Libraries\Chunks\Chunk;

/**
* cmex! Standard Text
* 
* @version 1.0
* @author David Bohn
* @copyright 2013 cmex! Team
*/
class Block extends Chunk implements SearchableInterface
{

    public function getIndex()
    {
        return strip_tags($this->content);
    }

    public function show()
    {
        $_ = $this;
        // TODO: The cache should be refreshed when the updated_at
        // flag is behind the cache-date!
        $value = \Cache::remember(
            $this->identifier,
            10,
            function () use ($_) {
                $v = \View::make(
                    "Text.views.textview",
                    array(
                        'content' => $_->content
                    )
                );

                return $v->render();
            }
        );

        if (\Authentication::check()) {
            return '<div property="text">' . $value . '</div>';
        }

        return $value;
    }

    public function handleInput($data)
    {
        return true;
    }

    public function annotate()
    {
        return array();
    }
}
