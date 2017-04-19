<?php

require dirname(__FILE__) . '/../env.php';

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

require dirname(__FILE__) . '/../vendor/autoload.php';

// include the frame work
require(__DIR__ . '/../vendor/cclark61/phpopenfw2/framework/phplitefw.inc.php');

// Start the liteFW controller and load the form engine and the database engine
$pco = new phplitefw_controller();
$pco->load_db_engine();
$pco->load_db_config(__DIR__ . "/../db.php", true);
$pco->default_data_source('main');

$pco->set_plugin_folder(dirname(__FILE__) . '/../classes');
spl_autoload_register('load_plugin');


$GLOBALS['data1'] = $data1 = new data_trans('main');
$data1->set_opt('make_bind_params_refs', 1);
$data1->set_opt('charset', 'utf8');

$powerball = new Powerball();

$winningNumbers = new WinningNumbers();
$powerballWinningNumbers = $winningNumbers->powerballRecentRules();

print "There are " . count($powerballWinningNumbers['data']) . " drawings...\n\n";

$randomNumbers = $powerball->generateRandomSelectionByMostUsed();
function simulateUntilThreeMatches($winningNumbers=[], $qualifiedMatches=[], $attempts=1) {
    global $powerball, $randomNumbers;
    $randomNumbers = $powerball->generateRandomSelectionByMostUsed();

    $primaryNumbers = [];
    $powerWinningNumber = $winningNumbers['draw_num6'];

    print "    Attempt #" . $attempts . "\n";
    print "    Checking drawing date: " . $winningNumbers['draw_date'] . "\n";

    //------------------------------------------------------------
    // Build up the primary numbers
    //------------------------------------------------------------
    array_push($primaryNumbers, $winningNumbers['draw_num1']);
    array_push($primaryNumbers, $winningNumbers['draw_num2']);
    array_push($primaryNumbers, $winningNumbers['draw_num3']);
    array_push($primaryNumbers, $winningNumbers['draw_num4']);
    array_push($primaryNumbers, $winningNumbers['draw_num5']);

    //------------------------------------------------------------
    // Build up the matches based on the primary numbers
    //------------------------------------------------------------
    $randomPrimaryNumbers = [
        $randomNumbers['data'][0],
        $randomNumbers['data'][1],
        $randomNumbers['data'][2],
        $randomNumbers['data'][3],
        $randomNumbers['data'][4]
    ];
    $randomPowerNumber = $randomNumbers['data'][5];

    print "    Winning Primary Numbers: " . implode(',', $primaryNumbers) . "\n";
    print "    Random Primary Numbers: " . implode(',', $randomPrimaryNumbers) . "\n";

    print "    Winning Power Number: " . $powerWinningNumber . "\n";
    print "    Random Power Number: " . $randomPowerNumber . "\n";


    $primaryMatches = [];
    foreach ($primaryNumbers as $primaryNumber) {
        if (in_array($primaryNumber, $randomPrimaryNumbers)) {
            array_push($primaryMatches, $primaryNumber);
        }
    }

    $totalPrimaryMatches = count($primaryMatches);

    print "    Primary Number Matches = " . $totalPrimaryMatches . "\n";

    $winningAmount = 0;
    //------------------------------------------------------------
    // Build up the qualified matches array
    // Powerball only...
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 0 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 4.00;
        print "    Powerball Only match!\n";
        array_push($qualifiedMatches, [
            'match_type'    => 'powerball_only',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }

    //------------------------------------------------------------
    // Build up the qualified matches array
    // 1 + Powerball match
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 1 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 4.00;
        print "    1 + Powerball match!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '1_plus_powerball',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    //------------------------------------------------------------
    // Build up the qualified matches array
    // 2 + Powerball
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 2 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 7.00;
        print "    2 + Powerball match!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '2_plus_powerball',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    //------------------------------------------------------------
    // Build up the qualified matches array
    // 3 matches
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 3 && $randomPowerNumber != $powerWinningNumber) {
        $winningAmount = 7.00;
        print "    3 matches only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '3_matches',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }

    //------------------------------------------------------------
    // Build up the qualified matches array
    // 3 + Powerball
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 3 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 100.00;
        print "    3 + Powerball only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '3_plus_powerball',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }

    //------------------------------------------------------------
    // Build up the qualified matches array
    // 4
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 4 && $randomPowerNumber != $powerWinningNumber) {
        $winningAmount = 100;
        print "    3 + Powerball only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '4_matches',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    //------------------------------------------------------------
    // Build up the qualified matches array
    // 4 + Powerball
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 4 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 50000;
        print "    4 + Powerball only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '4_plus_powerball',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    //------------------------------------------------------------
    // Build up the qualified matches array
    // 5 matches
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 5 && $randomPowerNumber != $powerWinningNumber) {
        $winningAmount = 1000000;
        print "    4 + Powerball only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '5 matches',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    //------------------------------------------------------------
    // Build up the qualified matches array
    // 5 + Powerball
    //------------------------------------------------------------
    if ($totalPrimaryMatches == 5 && $randomPowerNumber == $powerWinningNumber) {
        $winningAmount = 100000000;
        print "    4 + Powerball only!\n";
        array_push($qualifiedMatches, [
            'match_type'    => '4_plus_powerball',
            'amount'        => $winningAmount,
            'attempts'      => $attempts
        ]);
    }


    if ($winningAmount > 0) {
        print "    Got a winner worth: " . $winningAmount . "\n";
    }


    if ($attempts == 5) {
        print "\n";
        return ['qualifiedMatches'=>$qualifiedMatches, 'total_attempts'=>$attempts];
    }


    $attempts++;
    if (empty($qualifiedMatches)) {
        print "    This one has less then 3, try for a new random number!\n";
        print "\n";
        return simulateUntilThreeMatches($winningNumbers, $qualifiedMatches, $attempts);
    }

    print "\n";

    return ['qualifiedMatches'=>$qualifiedMatches, 'total_attempts'=>$attempts];
}


$results = [];
foreach($powerballWinningNumbers['data'] as $key => $powerballWinningNumber) {

    print "Trying for Draw Date: " . $powerballWinningNumber['draw_date'] . "\n";

    $qualifiedMatches = simulateUntilThreeMatches($powerballWinningNumber);

    array_push($results, $qualifiedMatches);

}

$totalSpent = 0;
$totalWon = 0;

foreach($results as $result) {
    $totalSpent += $result['total_attempts']*2;
    if (!empty($result['qualifiedMatches'])) {
        $totalWon += $result['qualifiedMatches'][0]['amount'];
    }

}

print "Total Spent: " . $totalSpent . "\n";
print "Total Won: " . $totalWon . "\n";

$totalLoss = $totalWon-$totalSpent;
print "Total Loss: " . $totalLoss  . "\n";

print "\n";


