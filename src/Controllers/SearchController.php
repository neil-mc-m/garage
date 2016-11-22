<?php

namespace CMS\Controllers;

use Silex\Application;

/**
 * The search controller for the livesearch feature.
 *
 * @class SearchController
 */
class SearchController
{
    public function searchAction(Application $app, $q)
    {
        // the search script called by the AJAX function for the live search feature
        // gets the value being typed into the search box,
        // passes it to a database function,
        $result = $app['dbrepo']->search($q);
        $resultArrayLength = sizeof($result);
        if (!$result) {
            return 'No matches found. Sorry.';
        } else {
            for ($row = 0; $row < $resultArrayLength; ++$row) {
                $id = $result[$row]['id'];
                $make = $result[$row]['make'];
                $model = $app['slugify']->slugify($result[$row]['model']);

                return "<a class='uk-contrast' href='/sales/details/{$make}/{$model}/{$id}'>" . $make . " " . $model . "</a>";
            }
        }
    }

}
