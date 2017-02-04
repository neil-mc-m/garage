<?php

/**
 * Created by PhpStorm.
 * User: neil
 * Date: 15/11/2016
 * Time: 22:39.
 */

namespace CMS\Controllers;

use CMS\Forms\CreateNewPromotionType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PromotionController
{
    public function viewPromotionsAction(Application $app)
    {
        $promos = $app['dbrepo']->getAllPromotions();
        $args_array = array(
            'promotions' => $promos,
            'user' => $app['session']->get('user'),
        );
        $templateName = '_promotions';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function createPromotionAction(Request $request, Application $app)
    {
        $count = 0;
        $data = array(

        );
        $form = $app['form.factory']
            ->createBuilder(CreateNewPromotionType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $count = $app['dbrepo']->createNewPromotion($data);
        }

        $templateName = '_promotionFormHolder';
        $args_array = array(
            'user' => $app['session']->get('user'),
            'form' => $form->createView(),
            'count' => $count,
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function deletePromotionAction(Application $app, $id)
    {
        $db = $app['dbrepo'];
        $count = $db->deletePromotion($id);
        $promotions = $db->getAllPromotions();
        $args_array = array(
            'count' => $count,
            'promotions' => $promotions,
            'user' => $app['session']->get('user'),
        );
        $templateName = '_promotions';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
