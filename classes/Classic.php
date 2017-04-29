<?php

class Classic {

    public $lastDrawDate;

    public function __construct()
    {
        $sql = 'SELECT draw_date FROM classic ORDER BY draw_date DESC';
        $lastDrawDate = qdb_lookup('main', $sql, 'draw_date');

        $this->lastDrawDate = ($lastDrawDate !== false) ? date('Y-m-d', strtotime($lastDrawDate)) : '2011-01-01';
    }
    
    public function getUsedNumbers()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = '
        SELECT COUNT(*) as total, number_used FROM classic_used_numbers 
        WHERE is_classic = 0 
        AND number_used <= 69
        GROUP BY number_used
        ORDER BY total ASC
        ';
        $res = qdb_list('main', $sql);

        $response['data'] = $res;

        return $response;
    }
    public function getUsedClassicNumbers()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = '
        SELECT COUNT(*) as total, number_used FROM classic_used_numbers 
        WHERE is_classic = 1 
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

        $mostUsedNumbers = array_slice($usedNumbers['data'], -6);

        $response['data'] = [
            $mostUsedNumbers[0]['number_used'],
            $mostUsedNumbers[1]['number_used'],
            $mostUsedNumbers[2]['number_used'],
            $mostUsedNumbers[3]['number_used'],
            $mostUsedNumbers[4]['number_used'],
            $mostUsedNumbers[5]['number_used']
        ];

        return $response;
    }

    public function generateSelectionByLeastUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $usedNumbers = $this->getUsedNumbers();

        $leastUsedNumbers = array_slice($usedNumbers['data'], 6);

        $response['data'] = [
            $leastUsedNumbers[0]['number_used'],
            $leastUsedNumbers[1]['number_used'],
            $leastUsedNumbers[2]['number_used'],
            $leastUsedNumbers[3]['number_used'],
            $leastUsedNumbers[4]['number_used'],
            $leastUsedNumbers[5]['number_used']
        ];

        return $response;
    }


    public function generateRandomSelectionByMostUsed()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $topNumbers = 50;
        $topClassicNumbers = 20;
        $usedNumbers = $this->getUsedNumbers();

        $mostUsedNumbers = array_slice($usedNumbers['data'], -$topNumbers);

        $uniqueIndexes = $this->generateUniqueNumbers(0, $topNumbers-1, 5);
        $uniqueIndexClassic = $this->generateUniqueNumbers(0, $topClassicNumbers-1, 1);

        $key0 = $uniqueIndexes[0];
        $key1 = $uniqueIndexes[1];
        $key2 = $uniqueIndexes[2];
        $key3 = $uniqueIndexes[3];
        $key4 = $uniqueIndexes[4];
        $key5 = $uniqueIndexes[5];

        $ClassicKey0 = $uniqueIndexClassic[0];

        $response['data'] = [
            $mostUsedNumbers[$key0]['number_used'],
            $mostUsedNumbers[$key1]['number_used'],
            $mostUsedNumbers[$key2]['number_used'],
            $mostUsedNumbers[$key3]['number_used'],
            $mostUsedNumbers[$key4]['number_used'],
            $mostUsedNumbers[$key5]['number_used']
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


    public function getClassicResultsFromRemote($startDate='2011-01-01', $endDate='')
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        if (empty($endDate)) {
            $endDate = date('Y-m-d');
        }
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.michiganlottery.com/v1/milotto/players/winning_numbers/past/6/'.$startDate . '/' . $endDate  . '.json?both=0');
        $tmpResponse = json_decode($res->getBody(), true);

        $response['data'] = $tmpResponse;

        return $response;
    }
}