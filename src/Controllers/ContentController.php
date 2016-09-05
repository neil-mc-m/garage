<?php

namespace CMS\Controllers;

use CMS\CreateNewCarType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * The Content Controller class.
 * 
 * Used for processing requests for content. CRUD actions on content
 */
class ContentController
{
    /**
     * 
     */
    public function contentAction( Application $app)
    {
        $content = $app['dbrepo']->getAllPagesContent();

        $args_array = array(
            'content' => $content,
            'user' => $app['session']->get('user'),
        );

        $templateName = '_content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function singleContentAction(Application $app, $contentId)
    {
        $content = $app['dbrepo']->showOne($contentId);

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

    public function createContentFormAction(Request $request, Application $app)
    {
        $count = 0;
        $data = array(

        );
        $form = $app['form.factory']
            ->createBuilder(CreateNewCarType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $count = $app['dbrepo']->createNewCar($data);
        }


        $templateName = '_contentForm';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
            'count' => $count
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);

    }
    public function processContentAction(Request $request, Application $app)
    {
        $pageName = $app['request']->get('pageName');
        $contentType = $app['request']->get('contentType');
        $contentItemTitle = $app['request']->get('contentItemTitle');
        $contentItem = $app['request']->get('contentItem');
        $result = $app['dbrepo']->createContent($pageName, $contentType, $contentItemTitle, $contentItem);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
            );

        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function deleteContentFormAction(Request $request, Application $app)
    {
        $allContent = $app['dbrepo']->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'allcontent' => $allContent,
        );

        $templateName = '_deleteContentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processDeleteContentAction(Request $request, Application $app, $contentId)
    {
        $db = $app['dbrepo'];
        $result = $db->deleteContent($contentId);
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
            'result' => $result,
            );

        $templateName = '_content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function editContentAction(Request $request, Application $app, $contentId)
    {
        $content = $app['dbrepo']->showOne($contentId);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
            );

        $templateName = '_editContentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processEditContentAction(Request $request, Application $app)
    {
        $contentId = $app['request']->get('contentId');
        $pageName = $app['request']->get('pageName');
        $contentType = $app['request']->get('contentType');
        $contentItemTitle = $app['request']->get('contentItemTitle');
        $contentItem = $app['request']->get('contentItem');
        $result = $app['dbrepo']->editContent($contentId, $pageName, $contentType, $contentItemTitle, $contentItem);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
            );

        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
