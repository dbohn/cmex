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
        'content' => '[{"name":"main","type":"text"},{"name":"mailform","type":"contact"}]',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'aboutus_content',
        'type' => 'Container',
        'content' => '[{"name":"main","type":"text"}]',
        'page' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'searchresults_content',
        'type' => 'Container',
        'content' => '[{"name":"myresults","type":"search_SearchResults"}]',
        'page' => 4,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_mailform',
        'type' => 'Contact',
        'content' => '{"to":"davbohn@googlemail.com", "template":"contactform"}',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'home_main',
        'type' => 'Text',
        'content' => '<h4>Download</h4> <p>Laden Sie die neueste Version herunter!</p>',
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
        'name' => 'aboutus_main',
        'type' => 'Text',
        'content' => '<p>Wir über uns</p>',
        'page' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'searchresults_myresults',
        'type' => 'search_SearchResults',
        'content' => '{}',
        'page' => 4,
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
    ),
    array(
        'name' => 'global_sidesearch',
        'type' => 'Search_SmallSearchForm',
        'content' => '{"page":"searchresults", "chunk":"myresults"}',
        'page' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    )
);