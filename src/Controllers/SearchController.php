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
        // the search script called by the AJAX function for the live search feature
        // gets the value being typed into the search box,
        // passes it to a database function,
//        $result = $app['dbrepo']->search($q);
//        $resultArrayLength = sizeof($result);
//        if (!$result) {
//            return 'No matches found. Sorry.';
//        } else {
//            for ($row = 0; $row < $resultArrayLength; ++$row) {
//                $id = $result[$row]['id'];
//                $make = $result[$row]['make'];
//                $model = $app['slugify']->slugify($result[$row]['model']);
//
//                return "<a class='uk-contrast' href='/sales/details/{$make}/{$model}/{$id}'>" . $make . " " . $model . "</a>";
//            }
//        }
        $query = $request->get('search');

        $searchResults = $app['dbrepo']->search($query);
        $keysArray = array('title', 'url', 'text');
        $valArray = array();
        foreach ($searchResults as $key => $val) {
                array_push($valArray, $val);
            }
            foreach ($valArray as $value) {
                $value['id'] = '/sales/details/'.$value['make'].'/'.$value['model'].'/'.$value['id'];
                $resArray = array_combine($keysArray, $value);
            }

            $res = json_encode(array("results" => array($resArray)));
            return $res;


    }

}
