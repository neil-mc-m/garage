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
 * @Class MainController.
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
//        $db = $app['dbrepo'];
		# as this is the home page controller, get the home pages content
//		$content = $db->getContent('home');
//		$allContent = $db->getAllPagesContent();
		$args_array = array(
//			'allContent' => $allContent,
//			'content' => $content,
		);
		$templateName = 'home';

		return $app['twig']->render($templateName . '.html.twig', $args_array);
	}


    /**
     * Sales page controller.
     *
     * @param Application $app
     * @return mixed
     */
    public function salesAction(Application $app)
    {
        // first we get all cars from the database
        $db = $app['dbrepo'];
        $result = $db->getCars();
        foreach ($result as $row){
            $id  = $row->id;
        }
        var_dump($id);
        $image = $db->getOneCarImage($id);
        $args_array = array(
            'result' => $result,
            'image' => $image
        );
        $templateName = 'sales';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
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
		$pageName = $db->getPageName($pageRoute);
		$singlePage = $db->getSinglePage($pageName);
//		$content = $db->getContent($pageName);
//		$allContent = $db->getAllPagesContent();
        $result = $db->getCars();


		$args_array = array(
		    'result' => $result,
			'pageName' => $singlePage->getPageName(),
            'sent' => $sent
		);

		return $app['twig']->render($singlePage->getPageTemplate() . '.html.twig', $args_array);
	}
	/**
	 * display one article.
	 *
	 * renders a template with one article.
	 *
	 * @param Request
	 * @param Application
	 *
	 * @return an article template.
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
            'pageName' => $pageName
		);
		$templateName = 'single_car';

		return $app['twig']->render($templateName . '.html.twig', $args_array);
	}

	public function contactFormAction(Request $request, Application $app)
    {
        $sent = false;
        $data = array(
            'name' => '',
            'email' => '',
            'message' => ''
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
                ->setTo(array('neilo2000@gmail.com'))
                ->setReplyTo(array($data['email'] => $data['name']))
                ->setBody($data['message']);
            $app['mailer']->send($message);
            $sent = true;
        }
        $templateName = 'contact';
        $args_array = array(
            'form' => $form->createView(),
            'sent' => $sent
        );
        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

}
