<?php

if(!function_exists('rawChunk')) {
    function rawChunk($name, $type, $scope) {
        if(($class = isValidChunk($type)) !== false) {
            $chunk = new $class();

            if($chunk->fetchByChunkName($scope, $name)) {
                return $chunk;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if(!function_exists('chunk')) {
    function chunk($name, $type, $scope) {
        if(func_num_args() > 3) {
            $properties = func_get_args();
            unset($properties[0]);
            unset($properties[1]);
            unset($properties[2]);
        } else {
            $properties = null;
        }
        
        if(($class = isValidChunk($type)) !== false) {
            $chunk = new $class();

            if(!is_null($properties)) {
                $chunk->setProperties((array)$properties);
            }

            $chunk->setChunkName($scope, $name);
            try {
                Event::fire('Loading chunk', array('scope' => $scope, 'name' => $name));
                if(Input::has("chunk") && Input::get("chunk") == $scope . "_" . $name) {
                    $chunk->handleInput(Input::get());
                }
                if(Auth::check()) {
                    return '<div id="'.$scope.'_'.$name.'">'. $chunk->handleConfig() . $chunk->show() . '</div>';
                }

                return $chunk->show();
            } catch(ChunkNotFoundException $e) {
                return "{{ Chunk data was not found! }}";
            } catch(Exception $generalException) {
                return $generalException->getMessage();
            }
            //}
        } else {
            return "{{ Chunk " . $type . " not found }}";
        }
    }
}

if(!function_exists('isValidChunk')) {
    function isValidChunk($name, $core = false) {
        $name = str_replace("_", "\\", $name);
        $class = "Chunks\\Cmex\\".ucfirst($name);
        return class_exists($class) ? $class : false;
    }
}
