<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The security controller responsible for logging in.
 *
 * @class SecurityController
 */
class SecurityController
{
    /**
     * A controller to handle logging in.
     *
     * @param Request     $request current request object
     * @param Application $app     current app instance
     *
     * @return twig template        a log in form
     */
    public function logInAction(Request $request, Application $app)
    {
        $args_array = array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        );
        $templateName = 'login';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function logoutAction(Application $app)
    {
        return $app->redirect('/');
    }
}
