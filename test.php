<?php
/**
 * Created by PhpStorm.
 * User: kristepherkrebs
 * Date: 5/10/17
 * Time: 11:02 PM
 */

require dirname(__FILE__) . '/env.php';
require dirname(__FILE__) . '/shared-config.php';


use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

//$drawGames = ['powerball', 'fantasy', 'classic', 'mega'];
$drawGames = ['fantasy'];

foreach ($drawGames as $drawGame) {
    getWeightedDraw($drawGame);
}

function getWeightedDraw($drawGame='') {
    if(!empty($drawGame)) {
        $Game = ucfirst($drawGame);
        $game = new $Game();

        $getSample = 'get'.$Game.'ModifiedWeights';
        $modifiedWeightsResults = $game->$getSample();
        $data = $modifiedWeightsResults['data'];

        $modifiedWeights = [];

        foreach ($data as $k => $v) {
            array_push($modifiedWeights, $v['fantasy_weights.weight + fantasy_modifiers.current_redraw']);
        }

        //If I wanted to pull a string based on weight, I'd do this:
        $weights = array_values($modifiedWeights);
        $strings = array_keys($modifiedWeights);
        $index = getBucketFromWeights($weights);
        $selectedString = $strings[$index];

        print $selectedString."\n";

    }
}

/**
 * @param array $values - just the weights
 * @return integer A number between 0 and count($values) - 1
 */
function getBucketFromWeights($values) {
    $total = $currentTotal = $bucket = 0;
    $firstRand = mt_rand(1, 100);

    foreach ($values as $amount) {
        $total += $amount;
    }

    $rand = ($firstRand / 100) * $total;

    foreach ($values as $amount) {
        $currentTotal += $amount;

        if ($rand > $currentTotal) {
            $bucket++;
        }
        else {
            break;
        }
    }

    return $bucket;
}

