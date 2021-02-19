<?php

namespace Thoughtco\Redirects;

use Statamic;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
        parent::boot();

        // add our middleware
        Statamic::booted(function () {
            app('router')->prependMiddlewareToGroup('statamic.web', Http\Middleware\Redirects::class);
        });

        // after install we need to copy our global
        Statamic::afterInstalled(function ($command) {

            if (File::exists(resource_path('blueprints/collections/redirects.yaml')))
                return;

            $original = __DIR__.'/../resources/collections/redirects.yaml';
            $yaml = YAML::file($original)->parse();
            File::put(resource_path('blueprints/collections/redirects.yaml'), YAML::dump($yaml));

        });

    }
}
