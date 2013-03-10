<?php

namespace Cmex\Libraries\Meta;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['cmex.meta'] = $this->app->share(
            function ($app) {
                return $app->make('Cmex\Libraries\Meta\MetaInformation');
            }
        );

        $this->app['cmex.asset'] = $this->app->share(
            function ($app) {
                return new Asset($app['cmex.meta']);
            }
        );

        $app = $this->app;

        $this->app->after(
            function ($request, $response) use ($app) {
                if (!($response instanceof \Illuminate\Http\RedirectResponse)) {
                    $response->setContent(
                        str_replace(
                            '__scripts__',
                            $app['cmex.asset']->getScripts(),
                            $response->original
                        )
                    );
                    
                    $response->setContent(
                        str_replace(
                            '__head__',
                            $app['cmex.meta']->generate(),
                            $response->original
                        )
                    );

                    return $response;
                }
            }
        );
    }
}
