<?php
// Default route for any pages
Route::any('{page}', 'Cmex\Modules\Page\PageController@handlePageRequest');

Route::get('/', 'Cmex\Modules\Page\PageController@showHomePage');