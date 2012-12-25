<?php

return array(
    array(
        'name' => 'home_content',
        'type' => 'Container',
        'content' => '[{"name":"main","type":"text"}]',
        'page' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_content',
        'type' => 'Container',
        'content' => '[{"name":"main","type":"text"}]',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'home_main',
        'type' => 'Text',
        'content' => '<h1>Inhalt</h1> <p>Wenn wir diesen Text sehen, sind wir schon sehr weit!</p>',
        'page' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_main',
        'type' => 'Text',
        'content' => '<p>Wir freuen uns über jede Ihrer Anfragen. Selbstverständlich unterbreiten wir Ihnen auch unverbindliche Angebote zu Ihren Projekten.</p>',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'global_vertmenu',
        'type' => 'Menu',
        'content' => '[{"title":"Startseite","page":"home","children":[]},{"title":"\u00dcber uns","page":"aboutus","children":[{"title":"Kontakt","page":"contact","children":[]},{"title":"cancrisoft.net","extern":"http:\/\/cancrisoft.net","children":[]}]}]',
        'page' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    )
);