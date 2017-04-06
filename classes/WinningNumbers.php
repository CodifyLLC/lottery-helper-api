<?php

class WinningNumbers {
    public function powerball()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $sql = 'SELECT * FROM powerball';
        $res = qdb_list('main', $sql);

        $response['data'] = $res;

        return $response;
    }

    public function powerballFromRemote()
    {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';


        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.michiganlottery.com/v1/milotto/players/winning_numbers/past/P/2010-03-01/2017-03-29.json?both=0');
        $tmpResponse = json_decode($res->getBody(), true);

        $response['data'] = $tmpResponse;

        return $response;
    }
}