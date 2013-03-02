<?php
// Default route for any pages
Route::any('{page}', 'Cmex\Modules\Page\Controller\PageController@handlePageRequest');

Route::get('/', 'Cmex\Modules\Page\Controller\PageController@showHomePage');