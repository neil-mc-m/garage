<?php

namespace CMS\Controllers;

use CMS\Page;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PagesController
{
    public function viewPagesAction(Application $app)
    {
        $db = $app['dbrepo'];
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
        );
        $templateName = '_viewPages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    /**
     * A form to create a new web-page.
     *
     * @param Request     $request the request object
     * @param Application $app     the app object
     *
     * @return twig template        a create-page template
     */
    public function createPageAction(Application $app)
    {
        $args_array = array(
            'user' => $app['session']->get('user'),
        );
        $templateName = '_createPage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Controller to process creation of a new page.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return twig template
     */
    public function newPageAction(Application $app)
    {
        // these variables need to be filtered and sanitised
        // before insert into db.

        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
        $page = new Page();
        $page->setPageRoute(strtolower($pageName));

        $result = $app['dbrepo']->createPage($pageName, $page->getPageRoute(), $pageTemplate);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
        );
        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * A controller to render the delete page form.
     * 
     * @param request, the request object.
     * @param app, the application object ($app)
     * 
     * @return renders the delete page form.
     */
    public function deletePageAction(Application $app)
    {
        $args_array = array(
            'user' => $app['session']->get('user'),
        );
        $templateName = '_deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * A controller to process deleting a web page.
     * 
     * @param request object
     * @param app, the application object ($app)
     * 
     * @return processes and re-renders the delete page form.
     */
    public function processDeletePageAction(Application $app)
    {
        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
        $result = $app['dbrepo']->deletePage($pageName, $pageTemplate);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
        );
        $templateName = '_deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
