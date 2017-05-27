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
//$drawGames = ['fantasy'];
$drawGames = ['fantasy', 'classic'];

foreach ($drawGames as $drawGame) {
    if(!empty($drawGame)) {
        $Game = ucfirst($drawGame);
        $game = new $Game();

        $draw = $game->getWeightedDraw();
        $favoredDraw = $game->getFavoredDraw();
        $modifiedDraw = $game->getModifiedDraw();

        /*for($i=0; $i<20; $i++) {
            $draw = $game->getFavoredWeightedDraw();
            print "Draw for ".$Game." : ".json_encode($draw)."\n";
        }*/

        print "Draw for ".$Game." : ".json_encode($draw)."\n";
        print "Favored Draw for ".$Game." : ".json_encode($favoredDraw)."\n";
        print "Modified Draw for ".$Game." : ".json_encode($modifiedDraw)."\n";
        print "\n\n";
    }
}



