<?php

namespace Cmex\Libraries\Chunks;

use DB;
use IllegalArgumentException;

abstract class Chunk
{
    protected $name = "";
    protected $scope = "";
    public $type = "";
    public $multichunk = false;
    private $chunkstorage = null;

    public function __construct()
    {
        // Determine chunk type
        // PHP 5.3 goodness :D
        $type = get_called_class();
        $type = explode("\\", $type);
        $parts = count($type);
        $this->type = implode(".", array($type[$parts - 2], $type[$parts - 1]));
        
    }

    public function setChunkName($scope, $name)
    {
        $this->scope = $scope;
        $this->name = $name;
    }

    public function __get($key)
    {
        if ($key == 'content') {
            if ($this->chunkstorage === null) {
                $chunkdb = DB::table('chunks')->where('name', $this->scope . "_" . $this->name)->first();
                if ($chunkdb === null) {
                    throw new ChunkNotFoundException('Chunk was not found!');
                }
                $this->chunkstorage = array('content' => $chunkdb->content);
            }
            return $this->chunkstorage['content'];
        } elseif ($key == 'identifier') {
            return $this->scope . '_' . $this->name;
        }

        throw new IllegalArgumentException('Unknown property!');
    }

    /**
     * For the editing environment you often have to specify
     * some information for initializing the editor.
     * For example a container chunk should specify here, that it
     * contains other chunks, i.e. it is a multipart object.
     */
    abstract public function annotate();

    abstract public function handleInput($data);
}
