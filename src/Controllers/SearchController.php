<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


/**
 * The search controller for the livesearch feature.
 *
 * @class SearchController
 */
class SearchController
{
    public function searchAction(Request $request, Application $app)
    {

        $query = $request->request->get('search');
        $filteredQuery = filter_var($query, FILTER_SANITIZE_STRING);
        $searchResults = $app['dbrepo']->search($filteredQuery);
        $keysArray = array('title', 'url', 'text');
        $valArray = array();
        foreach ($searchResults as $key => $val) {
                array_push($valArray, $val);
            foreach ($valArray as $value) {
                $value['id'] = '/sales/details/'.$value['make'].'/'.$value['model'].'/'.$value['id'];
                $resArray = array_combine($keysArray, $value);
            }
        }


            $res = json_encode(array("results" => array($resArray)));
            return $res;


    }

}
