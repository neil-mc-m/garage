<?php

namespace CMS\Controllers;


use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;
use CMS\Image;

/**
 * The image controller used to view, add and upload image routes.
 *
 * @Class ImageController
 */
class ImageController
{
    /**
     * A route to retrieve images from the database and present
     * them to the user for adding to content.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function viewImagesAction(Request $request, Application $app)
    {
        $db = $app['dbrepo'];
        $images = $db->viewImages();
        $cars = $db->getCars();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'images' => $images,
            'cars' => $cars,
        );

        $templateName = '_viewImages';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    /**
     * A controller for adding images to an article.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function addImageAction(Application $app)
    {
        $db = $app['dbrepo'];
        $id = $app['request']->get('id');
        $imagePath = $app['request']->get('imagePath');

        $count = $db->addImage($imagePath, $id);
//        $content = $db->showOne($contentId);

        $args_array = array(
            'user' => $app['session']->get('user'),
//            'image' => $content->getImagePath(),
//            'contentitemtitle' => $content->getContentItemTitle(),
//            'contentitem' => $content->getContentItem(),
//            'created' => $content->getCreated(),
//            'contentid' => $content->getContentId(),
            'count' => $count,
        );
        $templateName = '_singleContent';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    /**
     * A controller for rendering the upload images form.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function uploadImageFormAction(Application $app)
    {
        #$db = new DbRepository($app['dbh']);

        $args_array = array(
            'user' => $app['session']->get('user'),

        );
        $templateName = '_uploadImageForm';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    /** A controller to delete an image path using the value from the
     *  id variable, from the database and
     *  also from the filesystem.
     *
     * @param Application $app
     * @param $id
     */
    public function deleteImageAction(Application $app, $id)
    {
        $db = $app['dbrepo'];

        $count = $db->deleteImage($id);
        $images = $db->viewImages();
        $args_array = array(
            'user' => $app['session']->get('user'),
            'count' => $count,
            'images' => $images,

        );
        $templateName = '_viewImages';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }
    
   
}
