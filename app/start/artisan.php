<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

// Module commands
Artisan::add(new ModuleCommand);
Artisan::add(App::make('ModuleAddCommand'));
Artisan::add(App::make('ModuleRefreshCommand'));
// Chunk commands
Artisan::add(new ChunkMakeCommand);