<?php

if(!function_exists('chunk')) {
    function chunk($name, $type, $scope) {
        //print_r(app());
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

            if($chunk->fetchByChunkName($scope . "_" . $name)) {
                return $chunk->show();
            } else {
                return "{{ Chunk data was not found! }}";
            }
        } else {
            return "{{ Chunk " . $type . " not found }}";
        }
    }
}

if(!function_exists('isValidChunk')) {
    function isValidChunk($name, $core = false) {
        $class = "Cmex\\Chunks\\".ucfirst($name)."Chunk";
        return class_exists($class) ? $class : false;
    }
}