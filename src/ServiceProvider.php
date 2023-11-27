<?php

namespace Thoughtco\Redirects;

use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    public $middlewareGroups = [
        'statamic.web' => [
            Http\Middleware\RedirectsMiddleware::class,
        ],
    ];

    public function bootAddon()
    {

        // after install we need to copy our global
        Statamic::afterInstalled(function ($command) {

            if (File::exists(resource_path('blueprints/collections/redirects/redirects.yaml')))
                return;

            if (!File::exists(resource_path('blueprints/collections/redirects/'))) {
                File::makeDirectory(resource_path('blueprints/collections/redirects/'), 0777, true, true);
            }

            $original = __DIR__.'/../resources/blueprints/redirects.yaml';
            $yaml = YAML::file($original)->parse();
            File::put(resource_path('blueprints/collections/redirects/redirects.yaml'), YAML::dump($yaml));

            $original = __DIR__.'/../resources/collections/redirects.yaml';
            $yaml = YAML::file($original)->parse();
            File::put(base_path('content/collections/redirects.yaml'), YAML::dump($yaml));

        });

    }
}
