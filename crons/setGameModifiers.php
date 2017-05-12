<?php

require dirname(__FILE__) . '/../env.php';
require dirname(__FILE__) . '/../shared-config.php';


use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;



// Fetch and Save Powerball from Remote...
$drawGames = ['powerball', 'fantasy', 'classic', 'mega'];
//$drawGames = ['fantasy'];

foreach ($drawGames as $drawGame) {
    setModifiers($drawGame);
}


function setModifiers($drawGame='') {

    global $data1;
    
    if(!empty($drawGame)) {
        $gameId = $drawGame.'_modifiers_id';
        $Game = ucfirst($drawGame);
        $game = new $Game();

        $getSample = 'get'.$Game.'Sample';
        $sample = $game->$getSample();
        $data = array_reverse($sample['data']);
        $drawArray = [];

        foreach ($data as &$v) {
            $tempArray = [];
            foreach ($v as &$detail) {
                array_push($tempArray, $detail);
            }
            array_push($drawArray, $tempArray);
        }

        $gameNumbers = [];

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
            array_push($gameNumbers, ($i));
        }

        foreach ($gameNumbers as $number) {
            $checkArray = [];
            $min = 0;
            $max = 0;
            $currentDay = 0;

            foreach ($drawArray as $key => $draw) {
                if(array_search(($number+1), $draw) !== false) {
                    array_push($checkArray, $key);
                }
            }

            $checkArrayCount = count($checkArray);

            foreach ($checkArray as $sampleKey => $samplePosition) {
                $nextPosition = ($sampleKey < ($checkArrayCount - 1)) ? ++$sampleKey : 0;
                $nextValue = ($nextPosition) ? $checkArray[$nextPosition] : 0;

                if($nextValue) {
                    $min = (($nextValue - $samplePosition) === 1) ? ++$min : $min;
                    $max = (($nextValue - $samplePosition) > $max) ? ($nextValue - $samplePosition): $max;
                }
                else {
                    $currentDay = 99 - $samplePosition;
                    $max = ($currentDay > $max) ? $currentDay: $max;
                }
            }

            $current = ($currentDay === 0) ? $min : ($currentDay/$max) * 100;

            //print $min . "\n";
            //print $max . "\n";
            //print $current . "\n";

            $params = ['dddi', $min, $max, $current, $number];
            $data1->prepare(
                'UPDATE '.$drawGame.'_modifiers 
                SET min_redraw = ?, max_redraw = ?, current_redraw = ?
                WHERE '.$gameId.' = ?');
            $data1->execute($params);
        }

    }


}