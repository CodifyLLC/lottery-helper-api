<?php

class Powerball {
    
    public $lastDrawDate;

    public function __construct()
    {
        $sql = 'SELECT draw_date FROM powerball ORDER BY draw_date DESC';
        $lastDrawDate = qdb_lookup('main', $sql, 'draw_date');

        $this->lastDrawDate = ($lastDrawDate !== false) ? date('Y-m-d', strtotime($lastDrawDate)) : '2010-03-01';
    }

    public function getUsedNumbers()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = '
        SELECT COUNT(*) as total, number_used FROM powerball_used_numbers 
        WHERE is_powerball = 0 
        AND number_used <= 69
        GROUP BY number_used
        ORDER BY total ASC
        ';
        $res = qdb_list('main', $sql);

        $response['data'] = $res;

        return $response;
    }
    public function getUsedPowerNumbers()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = '
        SELECT COUNT(*) as total, number_used FROM powerball_used_numbers 
        WHERE is_powerball = 1 
        AND number_used <= 26
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
        $usedPowerNumbers = $this->getUsedPowerNumbers();

        $mostUsedNumbers = array_slice($usedNumbers['data'], -5);
        $mostUsedPowerNumbers = array_slice($usedPowerNumbers['data'], -1);

        $response['data'] = [
            $mostUsedNumbers[0]['number_used'],
            $mostUsedNumbers[1]['number_used'],
            $mostUsedNumbers[2]['number_used'],
            $mostUsedNumbers[3]['number_used'],
            $mostUsedNumbers[4]['number_used'],
            $mostUsedPowerNumbers[0]['number_used']
        ];

        return $response;
    }

    public function generateSelectionByLeastUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $usedNumbers = $this->getUsedNumbers();
        $usedPowerNumbers = $this->getUsedPowerNumbers();

        $leastUsedNumbers = array_slice($usedNumbers['data'], 5);
        $leastUsedPowerNumbers = array_slice($usedPowerNumbers['data'], 1);

        $response['data'] = [
            $leastUsedNumbers[0]['number_used'],
            $leastUsedNumbers[1]['number_used'],
            $leastUsedNumbers[2]['number_used'],
            $leastUsedNumbers[3]['number_used'],
            $leastUsedNumbers[4]['number_used'],
            $leastUsedPowerNumbers[0]['number_used']
        ];

        return $response;
    }


    public function generateRandomSelectionByMostUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $topNumbers = 50;
        $topPowerNumbers = 20;
        $usedNumbers = $this->getUsedNumbers();
        $usedPowerNumbers = $this->getUsedPowerNumbers();

        $mostUsedNumbers = array_slice($usedNumbers['data'], -$topNumbers);
        $mostUsedPowerNumbers = array_slice($usedPowerNumbers['data'], -$topPowerNumbers);

        $uniqueIndexes = $this->generateUniqueNumbers(0, $topNumbers-1, 5);
        $uniqueIndexPowerball = $this->generateUniqueNumbers(0, $topPowerNumbers-1, 1);

        $key0 = $uniqueIndexes[0];
        $key1 = $uniqueIndexes[1];
        $key2 = $uniqueIndexes[2];
        $key3 = $uniqueIndexes[3];
        $key4 = $uniqueIndexes[4];

        $powerKey0 = $uniqueIndexPowerball[0];

        $response['data'] = [
            $mostUsedNumbers[$key0]['number_used'],
            $mostUsedNumbers[$key1]['number_used'],
            $mostUsedNumbers[$key2]['number_used'],
            $mostUsedNumbers[$key3]['number_used'],
            $mostUsedNumbers[$key4]['number_used'],
            $mostUsedPowerNumbers[$powerKey0]['number_used']
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


    public function getPowerballSample($sampleCount=100)
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $sampleSql = 'SELECT draw_num1, draw_num2, draw_num3, draw_num4, draw_num5, draw_num6 FROM powerball ORDER BY powerball_id DESC LIMIT '.$sampleCount;
        $drawArray = qdb_list('main', $sampleSql);

        $response['data'] = $drawArray;

        return $response;
    }


    public function getPowerballResultsFromRemote($startDate='2010-03-01', $endDate='')
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        if (empty($endDate)) {
            $endDate = date('Y-m-d');
        }
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.michiganlottery.com/v1/milotto/players/winning_numbers/past/P/'.$startDate . '/' . $endDate  . '.json?both=0');
        $tmpResponse = json_decode($res->getBody(), true);

        $response['data'] = $tmpResponse;

        return $response;
    }
}