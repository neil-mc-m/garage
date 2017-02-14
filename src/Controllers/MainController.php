<?php

/**
 * The main controller.
 */

namespace CMS\Controllers;

use Silex\Application;
use CMS\Forms\ContactType;
use Symfony\Component\Httpfoundation\Request;

/**
 * The Main Controller used for the 'main' routes out of index.php.
 *
 * MainController.
 */
class MainController
{
    /**
     * home page Controller.
     *
     * Renders a template for the homepage.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return homepage template
     */
    public function indexAction(Application $app)
    {
        $promo = $app['dbrepo']->getAllPromotions();
        $args_array = array(
            'promotions' => $promo,
        );
        $templateName = 'home';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Main routing out of the home page.
     *
     * @param Request     $request [description]
     * @param Application $app     [description]
     * @param string      $page    the route/link used from the home page
     *
     * @return twig template        the requested twig template.
     */
    public function routeAction(Application $app, $pageRoute)
    {
        $sent = false;
        $db = $app['dbrepo'];

        if (!$pageName = $db->getPageName($pageRoute)) {
            throw new \Exception();
        }

        $singlePage = $db->getSinglePage($pageName);
        $result = $db->getCars();

        $args_array = array(
            'result' => $result,
            'pageName' => $singlePage->getPageName(),
            'sent' => $sent,

        );

        return $app['twig']->render($singlePage->getPageTemplate().'.html.twig', $args_array);
    }
    /**
     * display one car details.
     *
     * renders a template with one car details.
     *
     * @param Request
     * @param Application
     * @param id
     *
     * @return a car detail template.
     */
    public function singleCarAction(Application $app, $pageRoute,  $id)
    {
        $db = $app['dbrepo'];
        $result = $db->getOneCar($id);
        $images = $db->getCarImages($id);
        $pageName = $db->getPageName($pageRoute);
        $args_array = array(
            'cars' => $result,
            'images' => $images,
            'pageName' => $pageName,
        );
        $templateName = 'single_car';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function contactFormAction(Request $request, Application $app)
    {
        $sent = false;
        $data = array(
            'name' => '',
            'email' => '',
            'message' => '',
        );
        $form = $app['form.factory']
            ->createBuilder(ContactType::class, $data)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject('McGoverns Contact form')
                ->setFrom(array($data['email'] => $data['name']))
                ->setTo(array('tommymcgov@gmail.com'))
                ->setReplyTo(array($data['email'] => $data['name']))
                ->setBody($data['message']);
            $app['mailer']->send($message);
            $sent = true;
        }
        $templateName = 'contact';
        $args_array = array(
            'form' => $form->createView(),
            'sent' => $sent,
            'pageName' => 'contact'
        );

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
