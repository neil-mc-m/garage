<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 30/08/2016
 * Time: 21:31.
 */

namespace CMS\ServiceProviders;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ImagesServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['images'] = function () use ($app) {
            return $app['dbrepo']->viewImages();
        };
    }
    public function boot(Application $app)
    {
    }
}
