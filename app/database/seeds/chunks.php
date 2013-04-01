<?php

return array(
    array(
        'name' => 'home_content',
        'type' => 'Container.Standard',
        'content' => '[{"name":"main","type":"Text.Html"}]',
        'page' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_content',
        'type' => 'Container.Standard',
        'content' => '[{"name":"main","type":"Text.Html"},{"name":"mailform","type":"Contact.Form"}]',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'aboutus_content',
        'type' => 'Container.Standard',
        'content' => '[{"name":"main","type":"Text.Html"}]',
        'page' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'searchresults_content',
        'type' => 'Container.Standard',
        'content' => '[{"name":"myresults","type":"Search.SearchResults"}]',
        'page' => 4,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_mailform',
        'type' => 'Contact.Form',
        'content' => '{"to":"davbohn@googlemail.com", "template":"contactform"}',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'home_main',
        'type' => 'Text.Html',
        'content' => '<h4>Download</h4> <p>Laden Sie die neueste Version herunter!</p>',
        'page' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'contact_main',
        'type' => 'Text.Html',
        'content' => '<p>Wir freuen uns über jede Ihrer Anfragen. Selbstverständlich unterbreiten wir Ihnen auch unverbindliche Angebote zu Ihren Projekten.</p>',
        'page' => 2,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'aboutus_main',
        'type' => 'Text.Html',
        'content' => '<p>Wir über uns</p>',
        'page' => 3,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'searchresults_myresults',
        'type' => 'Search.SearchResults',
        'content' => '{}',
        'page' => 4,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'global_vertmenu',
        'type' => 'Menu.Tree',
        'content' => '{}',
        'page' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'global_sidesearch',
        'type' => 'Search.SmallSearchForm',
        'content' => '{"page":"searchresults", "chunk":"myresults"}',
        'page' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    ),
    array(
        'name' => 'global_frontendlogin',
        'type' => 'Login.Form',
        'content' => '{"view":"Login.views.loginformview"}',
        'page' => 0,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
    )
);
