<?php

class Core {

    public function __construct()
    {

    }

    /**
     * @param $set
     *
     */
    public function getWeightedFromSet($set) {
        $weights = array_values($set);
        $strings = array_keys($set);
        $index = $this->getPickFromWeights($weights);

        return $strings[$index];
    }

    /**
     * @param array $values - just the weights
     * @return integer A number between 0 and count($values) - 1
     */
    private function getPickFromWeights($values) {
        $total = $currentTotal = $pick = 0;
        $firstRand = mt_rand(1, 100);

        foreach ($values as $amount) {
            $total += $amount;
        }

        $rand = ($firstRand / 100) * $total;

        foreach ($values as $amount) {
            $currentTotal += $amount;

            if ($rand > $currentTotal) {
                $pick++;
            }
            else {
                break;
            }
        }

        return $pick;
    }
}