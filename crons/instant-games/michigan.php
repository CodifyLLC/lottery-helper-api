<?php

require dirname(__FILE__) . '/../../env.php';

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

require dirname(__FILE__) . '/../../vendor/autoload.php';

// include the frame work
require(__DIR__ . '/../../vendor/cclark61/phpopenfw2/framework/phplitefw.inc.php');

// Start the liteFW controller and load the form engine and the database engine
$pco = new phplitefw_controller();
$pco->load_db_engine();
$pco->load_db_config(__DIR__ . "/../../db.php", true);
$pco->default_data_source('main');

$pco->set_plugin_folder(dirname(__FILE__) . '/../../classes');
$pco->set_plugin_folder(dirname(__FILE__) . '/../../functions');

$pco->load_plugin('all_apps');
spl_autoload_register('load_plugin');

$GLOBALS['data1'] = $data1 = new data_trans('main');
$data1->set_opt('make_bind_params_refs', 1);
$data1->set_opt('charset', 'utf8');


$client = new \GuzzleHttp\Client();
$res = $client->request('GET', 'https://www2.instantticketcontest.com/MI/InstantsPlus/remaining-prizes/');
$html = $res->getBody();

//----------------------------------------------------
// Start the DOMDocument object to parse the html
//----------------------------------------------------
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($doc);

//------------------------------------------------------------------
// Remove all boostrap, jQuery and others so we keep things new
//------------------------------------------------------------------
$nodePrizes = $xpath->query("//*[@class='game']");

$instant_games = [];

if (!is_null($nodePrizes)) {

    foreach ($nodePrizes as $element) {

        $name = $element->getAttribute('data-name');
        $price = $element->getAttribute('data-price');
        $releaseDate = $element->getAttribute('data-release-date');
        $releaseDate = date('Y-m-d H:i:s', $releaseDate);
        $nodes = $element->childNodes;

        print "Building Array for Game: " . $name . "\n";
        print "    Price: $price\n";
        print "    Release Date: $releaseDate\n";

        $instant_game = [];
        $instant_game['name'] = $name;
        $instant_game['price'] = $price;
        $instant_game['release_date'] = $releaseDate;

        foreach ($nodes as $node) {

            if ($node->nodeType == 1) {

                $imgElement = $node->getElementsByTagName('img');

                if (!empty($imgElement->item(0))) {
                    $instant_game['img_src'] = $imgElement->item(0)->getAttribute('src');
                }

                if ($node->hasAttribute('class'))
                {
                    $class = $node->getAttribute('class');

                    if (contains('table-striped', $class)) {

                        $body = $node->getElementsByTagName('tr');

                        foreach ($body as $node2) {
                            $cols = $node2->getElementsByTagName('td');

                            $count = 0;

                            $prize = $cols->item(0)->textContent;
                            $start = $cols->item(1)->textContent;
                            $remaining = $cols->item(2)->textContent;

                            print "    Prize: $prize\n";
                            print "        Starting Count: $start\n";
                            print "        Remaining Count: $remaining\n";

                            $instant_game['prize'] = $prize;
                            $instant_game['starting_count'] = $start;
                            $instant_game['remaining_count'] = $remaining;

                            array_push($instant_games, $instant_game);
                        }
                    }
                }
            }
        }

        print "\n\n";
    }


    $sql = 'INSERT INTO instant_michigan (price, 
                                      game_name, 
                                      image_url, 
                                      starting_count, 
                                      remaining_count, 
                                      prize, 
                                      release_date) 
            VALUES (?,?,?,?,?,?,?)';

    $data1->prepare($sql);
    foreach($instant_games as $game) {

        $name = html_entity_decode($game['name'], ENT_QUOTES);
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);

        $prize = str_replace('$', '', $game['prize']);
        $prize = str_replace(',', '', $prize);

        $starting_count = str_replace(',', '', $game['starting_count']);
        $remaining_count = str_replace(',', '', $game['remaining_count']);
        print "Processing: " . $name . "\n";
        print "    Prize: " . $prize . "\n";
        $params = ['sssssss',
            $game['price'],
            $name,
            $game['img_src'],
            $starting_count,
            $remaining_count,
            $prize,
            $game['release_date']
        ];

        $data1->execute($params);

        print "\n\n";
    }
}

print "\n\n";
print "Done!\n\n";