<?php

require dirname(__FILE__) . '/../env.php';
require dirname(__FILE__) . '/../shared-config.php';


use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;



// Fetch and Save Powerball from Remote...
$drawGames = ['powerball', 'fantasy', 'classic', 'mega'];

foreach ($drawGames as $drawGame) {
    setWeights($drawGame);
    setWeights($drawGame, 200);
    setWeights($drawGame, 300);
}


function setWeights($drawGame='', $sampleCount=100) {

    global $data1;
    
    if(!empty($drawGame)) {
        $gameId = $drawGame.'_weights_id';
        $Game = ucfirst($drawGame);
        $game = new $Game();

        $getSample = 'get'.$Game.'Sample';
        $sample = $game->$getSample($sampleCount);

        $drawArray = $sample['data'];

        $gameWeights = [];

        switch ($drawGame) {
            case 'powerball':
                $maxNumber = 69;
                break;
            case 'fantasy':
                $maxNumber = 39;
                break;
            case 'classic':
                $drawList = '';
                $maxNumber = 47;
                break;
            case 'mega':
                $maxNumber = 75;
                break;
            default:
                $maxNumber = 0;
                break;
        }

        for($i = 0; $i < $maxNumber; $i++) {
            array_push($gameWeights, $i);
        }
        
        foreach ($drawArray as $draw) {
            foreach ($draw as &$result) {
                ++$gameWeights[($result-1)];
            }
        }

        switch ($sampleCount) {
            case 100;
                $table = 'weight';
                break;
            case 200;
                $table = 'weight_by_two';
                break;
            case 300;
                $table = 'weight_by_three';
                break;
        }

        foreach ($gameWeights as $key => $weight) {
            $weight = round(100*$weight/$sampleCount, 3);

            $params = ['di', $weight, ++$key];
            $data1->prepare('UPDATE '.$drawGame.'_weights SET '.$table.' = ? WHERE '.$gameId.' = ?');
            $data1->execute($params);
        }
    }


}