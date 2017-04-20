<?php

require dirname(__FILE__) . '/../env.php';
require dirname(__FILE__) . '/../shared-config.php';


use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;




// Fetch and Save Powerball from Remote...
$powerball = new Powerball();
$powerballHistory = $powerball->getPowerballResultsFromRemote();

$numbers = $powerballHistory['data']['result']['winning_numbers'];

print "We have " . count($numbers) . " drawings to  get numbers for \n\n";

foreach ($numbers as $number) {

    print "    Checking draw date: " . $number['draw_date'] . "...";

    // Prevent duplicates...
    $sql = 'SELECT powerball_id FROM powerball WHERE draw_date = ?';
    $params = ['s', $number['draw_date']];
    $id = qdb_lookup('main', $sql, 'powerball_id', $params);

    if (empty($id)) {
        print "Does not exist, add it...";
        $params = ['iiiiiiss',
            $number['draw_num_1'],
            $number['draw_num_2'],
            $number['draw_num_3'],
            $number['draw_num_4'],
            $number['draw_num_5'],
            $number['draw_num_6'],
            $number['multiplier'],
            $number['draw_date']
        ];
        $data1->prepare('INSERT INTO powerball (draw_num1, draw_num2, draw_num3, draw_num4, draw_num5, draw_num6, multiplier, draw_date) VALUES (?,?,?,?,?,?,?,?)');
        $data1->execute($params);

        $lastId = $data1->last_insert_id();

        print "Adding used numbers...";
        for($i=1; $i<=6; $i++) {
            $data1->prepare('INSERT INTO powerball_used_numbers (powerball_id, number_used, is_powerball) VALUES (?,?,?)');

            $isPowerball = ($i==6) ? (1) : (0);
            $params = ['iii', $lastId, $number['draw_num_' . $i], $isPowerball];
            $data1->execute($params);
        }
        print "Done...";

        print "ID: " . $lastId . "\n";
    }
    else {
        print "Already in database!\n";
    }

    print "\n";

}
//print_r($numbers);