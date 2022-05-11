<?php

class Sylvane {

    private array $bins;

    public function __construct(array $bins) {
        $this->bins = $bins;
    }


    function getRandomBins ( $num_bins = 12 ) {

        $random_bins = array();

        $random_bin_index = array_rand($this->bins, $num_bins);

        foreach ($random_bin_index as $index) {
            array_push($random_bins, $this->bins[$index]);
        }

        return $random_bins;

    }

}
