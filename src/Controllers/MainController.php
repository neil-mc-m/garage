<?php
/**
 * The main controller.
 */

namespace CMS\Controllers;

use Silex\Application;
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
		$db = $app['dbrepo'];
		$pageName = $db->getPageName($pageRoute);
		$singlePage = $db->getSinglePage($pageName);
//		$content = $db->getContent($pageName);
//		$allContent = $db->getAllPagesContent();
        $result = $db->getCars();
        foreach ($result as $row){
            $id[] = $row->id;
        }
        var_dump($id);
        $images = $db->getLeadImages($id);

		$args_array = array(
		    'result' => $result,
			'pageName' => $singlePage->getPageName(),
			'image' => $images,
//			'allContent' => $allContent,
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

}
