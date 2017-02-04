<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\Filesystem\Filesystem;

/**
 * The image controller used to view, add and upload image routes.
 *
 *  ImageController
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
    public function viewImagesAction(Application $app)
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

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * A controller for adding images to an article.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function addImageAction(Application $app, $carid, $imageid)
    {
        $db = $app['dbrepo'];

        $count = $db->addImage($carid, $imageid);

        if ($count === 1) {
            $message = 'Success! This image was added to your chosen car.';

            return $message;
        } else {
            $message = 'Theres a problem with the response. Maybe its been added already?';

            return $message;
        }
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
        $args_array = array(
            'user' => $app['session']->get('user'),
        );
        $templateName = '_uploadImageForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
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
        $path = $db->getOneCarImage($id);
        $fs = new Filesystem();

        $fs->remove($path);
        $count = $db->deleteImage($id);

        if (!$count === 1) {
            $message = 'Theres a problem with the response.';

            return $message;
        } else {
            $message = 'Success! An image was deleted.';

            return $message;
        };
    }

    /**
     * Makes an image the lead image on the sales page for a car given the carid and imageid.
     *
     * @param Application $app
     * @param $carid
     * @param $imageid
     *
     * @return string
     */
    public function makeLeadImageAction(Application $app, $carid, $imageid)
    {
        $db = $app['dbrepo'];
        $count = $db->makeLeadImage($carid, $imageid);
        if ($count === 1) {
            $message = 'Success! This is now your new lead image for this car.';

            return $message;
        } else {
            $message = 'Theres a problem with the response. This may already be your main image.';

            return $message;
        }
    }
}
