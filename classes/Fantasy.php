<?php

class Fantasy {

    public $lastDrawDate;

    public function __construct()
    {
        $sql = 'SELECT draw_date FROM fantasy ORDER BY draw_date DESC';
        $lastDrawDate = qdb_lookup('main', $sql, 'draw_date');

        $this->lastDrawDate = ($lastDrawDate !== false) ? date('Y-m-d', strtotime($lastDrawDate)) : '2013-01-01';
    }

    public function getUsedNumbers()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = '
        SELECT COUNT(*) as total, number_used FROM fantasy_used_numbers 
        WHERE is_fantasy = 0 
        AND number_used <= 69
        GROUP BY number_used
        ORDER BY total ASC
        ';
        $res = qdb_list('main', $sql);

        $response['data'] = $res;

        return $response;
    }

    public function generateSelectionByMostUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $usedNumbers = $this->getUsedNumbers();

        $mostUsedNumbers = array_slice($usedNumbers['data'], -5);

        $response['data'] = [
            $mostUsedNumbers[0]['number_used'],
            $mostUsedNumbers[1]['number_used'],
            $mostUsedNumbers[2]['number_used'],
            $mostUsedNumbers[3]['number_used'],
            $mostUsedNumbers[4]['number_used']
        ];

        return $response;
    }

    public function generateSelectionByLeastUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $usedNumbers = $this->getUsedNumbers();

        $leastUsedNumbers = array_slice($usedNumbers['data'], 5);

        $response['data'] = [
            $leastUsedNumbers[0]['number_used'],
            $leastUsedNumbers[1]['number_used'],
            $leastUsedNumbers[2]['number_used'],
            $leastUsedNumbers[3]['number_used'],
            $leastUsedNumbers[4]['number_used']
        ];

        return $response;
    }


    public function generateRandomSelectionByMostUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $topNumbers = 50;
        $topFantasyNumbers = 20;
        $usedNumbers = $this->getUsedNumbers();

        $mostUsedNumbers = array_slice($usedNumbers['data'], -$topNumbers);

        $uniqueIndexes = $this->generateUniqueNumbers(0, $topNumbers-1, 5);
        $uniqueIndexFantasy = $this->generateUniqueNumbers(0, $topFantasyNumbers-1, 1);

        $key0 = $uniqueIndexes[0];
        $key1 = $uniqueIndexes[1];
        $key2 = $uniqueIndexes[2];
        $key3 = $uniqueIndexes[3];
        $key4 = $uniqueIndexes[4];

        $fantasyKey0 = $uniqueIndexFantasy[0];

        $response['data'] = [
            $mostUsedNumbers[$key0]['number_used'],
            $mostUsedNumbers[$key1]['number_used'],
            $mostUsedNumbers[$key2]['number_used'],
            $mostUsedNumbers[$key3]['number_used'],
            $mostUsedNumbers[$key4]['number_used']
        ];

        return $response;
    }

    private function generateUniqueNumbers($start, $end, $amountOfNumbers, $numbers=[])
    {
        $number = rand($start, $end);

        if (count($numbers) == $amountOfNumbers) {
            return $numbers;
        }

        if (!in_array($number, $numbers)) {
            array_push($numbers, $number);
        }

        return $this->generateUniqueNumbers($start, $end, $amountOfNumbers, $numbers);

    }

    public function getFantasyModifiedWeights($column='weight')
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $sampleSql = 
            'SELECT fantasy_weights.'.$column.' + fantasy_modifiers.current_redraw 
            FROM fantasy_weights CROSS JOIN fantasy_modifiers 
            WHERE fantasy_weights.fantasy_weights_id = fantasy_modifiers.fantasy_modifiers_id';
        $drawArray = qdb_list('main', $sampleSql);

        $response['data'] = $drawArray;

        return $response;
    }

    public function getFantasySample($sampleCount=100)
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $sampleSql = 'SELECT draw_num1, draw_num2, draw_num3, draw_num4, draw_num5 FROM fantasy ORDER BY fantasy_id DESC LIMIT '.$sampleCount;
        $drawArray = qdb_list('main', $sampleSql);

        $response['data'] = $drawArray;

        return $response;
    }


    public function getFantasyResultsFromRemote($startDate='2013-01-01', $endDate='')
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        if (empty($endDate)) {
            $endDate = date('Y-m-d');
        }
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.michiganlottery.com/v1/milotto/players/winning_numbers/past/5/'.$startDate . '/' . $endDate  . '.json?both=0');
        $tmpResponse = json_decode($res->getBody(), true);

        $response['data'] = $tmpResponse;

        return $response;
    }
}