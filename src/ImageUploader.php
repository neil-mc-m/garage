<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 17/10/2016
 * Time: 20:52
 */

namespace CMS;

use Silex\Application;
use CMS\Image;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    private $targetDir = 'images';
    private $app;
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function upload(UploadedFile $file)
    {
        if(!$file){
            $message = 'Sorry, theres no way to upload that file. check your php.ini directive.';
            return $message;
        }
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $constraint = new Assert\Image(array(
            'mimeTypes' => array('image/jpeg', 'image/png'),
            'maxSize' => '2M'
        ));
        $errors = $this->app['validator']->validate($file, $constraint);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage() . "\n";
                return $message;
            }
        }
        if (file_exists($this->targetDir . '/' . $fileName)) {
            $message = 'Sorry, file already exists';
            return $message;
        }
        $file->move($this->targetDir . '/' ,$fileName);
        $newImage = new Image();
        $newImage->setImagePath($fileName);
        $image = $newImage->getImagePath();
        $count = $this->app['dbrepo']->uploadImage($image);
        if (!$count === 1){
            return 'There was a problem with the upload.';
        } else {
            return 'Image file was successfully uploaded.';
        }
    }
}