<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 19/05/2016
 * Time: 00:35.
 */

namespace CMS\Controllers;

use Silex\Application;
use CMS\ImageUploader;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Upload.
 *
 * Handle file uploads.
 */
class UploadController
{
    /**
     * A controller for processing the upload images AJAX form.
     * Validations: a jpg or png, under 2M.
     * The image path will be stored in the db.
     *
     * @param request object
     * @param app object
     *
     * @return a message to display as a result from the AJAX call
     */
    public function processImageUploadAction(Request $request, Application $app)
    {
        $file = $request->files->get('image');
        $image = new ImageUploader($app);
        $result = $image->upload($file);

        return $result;
    }
}
