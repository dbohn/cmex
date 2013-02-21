<?php

namespace Chunks\Cmex;
use \Chunks\Cmex\Search\SearchableInterface;

class Container extends \Chunk implements SearchableInterface {
    private $loadedChunks = array();

    public $multichunk = true;

    public function config() {
        return "";
    }

    public function initialize()
    {
        /*$chunks = json_decode($this->content);
        foreach($chunks as $chunk)
        {
            if (property_exists($chunk, 'scope'))
            {
                $scope = $chunk->scope;
            } else
            {
                $scope = $this->scope;
            }

            $this->loadedChunks[] = \ChunkManager::add($chunk->name, $chunk->type, $scope);
        }*/

        $this->loadedChunks = $this->loadChunks();
    }

    protected function loadChunks()
    {
        $chunks = json_decode($this->content);
        $returnedChunks = array();

        foreach($chunks as $chunk)
        {
            if (property_exists($chunk, 'scope'))
            {
                $scope = $chunk->scope;
            } else
            {
                $scope = $this->scope;
            }

            $returnedChunks[] = \ChunkManager::add($chunk->name, $chunk->type, $scope);
        }

        return $returnedChunks;
    }

    public function getIndex() {
        $ret = array();
        //$chunks = json_decode($this->content);

        foreach($this->loadedChunks as $chunk)
        {
            $inst = \ChunkManager::getChunkForKey($chunk);

            if($inst instanceof SearchableInterface)
            {
                $ret[] = array('name' => $chunk, 'index' => $inst->getIndex());
            }
        }

        return $ret;
    }

    public function show() {
        
        $ret = "";
        /*if(\Authentication::check())
        {
            $ret = "<div about=\"chunks/container\" rel=\"dcterms:hasPart\"> ";
        }*/

        foreach($this->loadedChunks as $chunk)
        {
            $ret .= \ChunkManager::getChunkForKey($chunk)->show();
        }

        // if(\Authentication::check())
        // {
        //     $ret .= "</div>";
        // }

        return $ret;
    }

    public function annotate()
    {
        return array('multipart');
    }

    public function handleInput($data) {
        // Add chunk to container etc...
    }
}