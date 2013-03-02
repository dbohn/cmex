<?php

return array(
    'drivers' => array(
        'Cmex\Libraries\Media\Driver\FileSystem'
    ),

    'filesystem' => array(
        'baseUrl' => asset("files"),
        'basePath' => base_path() . "/public/files/"
    )
);