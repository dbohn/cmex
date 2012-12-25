<?php

return array(
    array(
        'name' => 'admin',
        'password' => Hash::make('admin'),
        'email' => 'davbohn@googlemail.com',
        'firstname' => 'David',
        'lastname' => 'Bohn',
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'rights' => 0
    ),
    array(
        'name' => 'editor',
        'password' => Hash::make('editor'),
        'email' => 'david@cancrisoft.net',
        'firstname' => 'Mark',
        'lastname' => 'Editor',
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'rights' => 1
    )
);