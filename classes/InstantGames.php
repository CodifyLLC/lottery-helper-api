<?php

class InstantGames {
    private $state;

    public function __construct()
    {

    }

    public function getAllPrizes() {
        $response = [];
        $response['status'] = 'ok';
        $response['message'] = 'Returned';

        $state = $this->getState();
        $sql = "SELECT * FROM instant_$state";
        $games = qdb_list('', $sql);

        $groupedGames = [];

        foreach($games as $game) {
            $gameKey = $this->getGameKey($game['game_name']);

            if (!isset($groupedGames[$gameKey])) {
                $groupedGames[$gameKey] = [
                    'releaseDate' => $game['release_date'],
                    'image_url' => $game['image_url'],
                    'game_name' => $game['game_name'],
                    'prizes' => []
                ];
            }

            array_push($groupedGames[$gameKey]['prizes'], $game);
        }

        $groupedGames = array_values($groupedGames);

        $response['data'] = $groupedGames;
        return $response;
    }

    public function getTop3MostRemaining($price)
    {
        $response = [];

        $response['status'] = 'ok';
        $response['message'] = 'returned';

        $state = $this->getState();

        if (!empty($price)) {
            $sql = "SELECT * FROM instant_$state WHERE price = ? GROUP BY game_name";
            $games = qdb_exec('', $sql, ['s', $price]);
        }
        else {
            $sql = "SELECT * FROM instant_$state GROUP BY game_name";
            $games = qdb_list('', $sql);
        }


        $groupedGames = [];

        foreach($games as $game) {
            $gameKey = $this->getGameKey($game['game_name']);

            $sql = "SELECT * FROM instant_$state WHERE game_name = ? AND remaining_count > 0 ORDER BY prize DESC LIMIT 3";
            $top_prizes = qdb_exec('', $sql, [
                's', $game['game_name']
            ]);


            if (!isset($groupedGames[$gameKey])) {
                $groupedGames[$gameKey] = [
                    'releaseDate' => $game['release_date'],
                    'image_url' => $game['image_url'],
                    'game_name' => $game['game_name'],
                    'prizes' => []
                ];
            }
            array_push($groupedGames[$gameKey]['prizes'], $top_prizes);
        }

        $groupedGames = array_values($groupedGames);



        $response['data'] = $groupedGames;

        return $response;

    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    private function getGameKey($gameName)
    {
        $gameKey = preg_replace('/[^\da-z]/i', '', $gameName);

        return $gameKey;
    }

}