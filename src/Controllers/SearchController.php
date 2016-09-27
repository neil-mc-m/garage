<?php

namespace CMS\Controllers;

use CMS\DbRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\Page;
/**
 * The search controller for the livesearch feature.
 * 
 * @Class SearchController
 */
class SearchController
{
    public function searchAction(Application $app, $q)
    {
        // the search script called by the AJAX function for the live search feature
        // gets the value being typed into the search box,
        // passes it to a database function,


        $user = $app['request']->get('user');
        
        $result = $app['dbrepo']->search($q);

        // the true flag will set the array to be associative
//        $value = json_decode($value, true);
//        return $value;

        for ($row = 0; $row < sizeof($result); ++$row) {
            $id = $result[$row]['id'];
            $make = $result[$row]['make'];

            return "<a class='uk-contrast' href='/sales/{$id}'>" . $make . " " . $result[$row]['model'] . "</a>";
        }
    }

    public function userAction(Request $request, Application $app, $contentId)
    {
        $db = new DbRepository($app['dbh']);
        $content = $db->showOne($contentId);
        $user = $app['session']->get('user');
        if ($user == false) {
            $allContent = $db->getAllPagesContent();

            $args_array = array(
                'allContent' => $allContent,
                'contentId' => $content->getContentId(),
                'pageName' => $content->getPageName(),
                'title' => $content->getContentitemtitle(),
                'article' => $content->getContentitem(),
                'image' => $content->getImagePath(),
                'created' => $content->getCreated(),
             );
            $templateName = 'onearticle';

            return $app['twig']->render($templateName.'.html.twig', $args_array);
        } else {
            $args_array = array(
                'user' => $app['session']->get('user'),
                'pagename' => $content->getPageName(),
                'contentitemtitle' => $content->getContentItemTitle(),
                'contentitem' => $content->getContentItem(),
                'created' => $content->getCreated(),
                'contentid' => $content->getContentId(),
            );

            $templateName = '_singleContent';

            return $app['twig']->render($templateName.'.html.twig', $args_array);
        }
    }
}
