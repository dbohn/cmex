<?php

if(!function_exists('chunk')) {
    function chunk($name, $type, $scope=null)
    {
        try {
            if(($chunkKey = ChunkManager::add($name, $type, $scope)) !== false)
            {
                if(func_num_args() > 3) {
                    $properties = array_slice(func_get_args(), 3);

                    ChunkManager::getChunkForKey($chunkKey)->setProperties($properties);
                }

                return '__' . $chunkKey . '__';
            }
        } catch (\Cmex\Libraries\Chunks\ChunkAlreadyExistsException $e)
        {
            return "{{ There are two chunks with the same name! }}";
        } catch (\Cmex\Libraries\Chunks\InvalidChunkTypeException $e)
        {
            return "{{ " . $e->getMessage() . " }}";
        }
    }
}

if (!function_exists('full_username')) {
    function full_username()
    {
        if (!Authentication::check()) {
            return "";
        }

        try
        {
            // Get the current active/logged in user
            $user = Authentication::getUser();

            return $user->first_name . " " . $user->last_name;
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return "";
        }
    }
}