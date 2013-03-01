<?php

namespace Chunks\Cmex\Container;
use \Chunks\Cmex\Search\SearchableInterface;

use \Cmex\ChunkManager\ChunkNotFoundException;
use \Cmex\ChunkManager\InvalidChunkTypeException;

class Standard extends \Chunk implements SearchableInterface {
    private $loadedChunks = array();

    private $errorChunks = array();

    public $multichunk = true;

    public function initialize()
    {
        $this->loadedChunks = $this->loadChunks();
    }

    protected function loadChunks()
    {
        $chunks = json_decode($this->content);
        $returnedChunks = array();

        foreach($chunks as $chunk)
        {
            if (property_exists($chunk, 'scope')) {
                $scope = $chunk->scope;
            } else {
                $scope = $this->scope;
            }
            try {
                $returnedChunks[] = \ChunkManager::add($chunk->name, $chunk->type, $scope);
            } catch (InvalidChunkTypeException $e) {
                $this->errorChunks[] = array(
                    "name" => $chunk->name,
                    "type" => $chunk->type,
                    "message" => $e->getMessage());
            }
        }

        return $returnedChunks;
    }

    public function getIndex() 
    {
        $ret = array();

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

    public function show() 
    {
        
        $ret = "";

        foreach($this->loadedChunks as $chunk)
        {
            try {
                $ret .= \ChunkManager::showForKey($chunk);
            } catch (ChunkNotFoundException $e) {
                $ret .= "{{ " . $e->getMessage . " }}";
            } catch (InvalidChunkTypeException $e) {
                $ret .= "{{ " . $e->getMessage() . " }}";
            }
        }

        foreach ($this->errorChunks as $echunk) {
            $ret .= "{{ Error for " . $echunk["name"] . ": " . $echunk["message"] ." }}";
        }

        return $ret;
    }

    public function annotate()
    {
        return array('multipart');
    }

    public function handleInput($data) 
    {
        // Add chunk to container etc...
    }
}