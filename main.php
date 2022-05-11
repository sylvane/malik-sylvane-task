<?php

require_once('params.php');
require_once('Graph.php');
require_once('PathFinder.php');
require_once('Sylvane.php');

$graph = new Graph ( $num_nodes );

foreach ($edges as $edge) {
    $graph->addEdge ( $edge[0], $edge[1] );
}

$bins = array_keys( $bin_mapping );
$bins = array_diff( $bins, ['start'] );

$sylvane = new Sylvane( $bins );
print_r($sylvane->getRandomBins(12));
$path_finder = new PathFinder ( $graph );

$final_path = [];

$current_node = 'start';

for($i = 0; $i < 12; $i++) {}

// print_r ( $paths );
// print_r ( $distances );
