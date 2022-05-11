<?php

require_once('params.php');
require_once('Graph.php');
require_once('PathFinder.php');
require_once('Sylvane.php');

/**
 * Returns the unvisited nearest bin.
 *
 * @param string $start
 *   The starting point of the bin.
 * @param array $bins
 *   The array of subset of the bins.
 * @param array $visited
 *   The array of visited bins.
 * @param array $distances
 *   The distance between all pairs in the graph.
 * @param array $bin_mapping
 *   The associaitve array of mapping bin to the node id.
 */
function getNearestBin($start, $bins, $visited, $distances, $bin_mapping) {

    // Get the index of the bin in the graph.
    $start_node_id = $bin_mapping[$start];

    // Get all the unvisited bins.
    $unvisited_bins = array_values(array_diff($bins, $visited));

    // Select the first bin as the nearest.
    $nearest = $unvisited_bins[0];

    // Get the index of the nearest bin.
    $nearest_node_id = $bin_mapping[$nearest];

    // Get the distance of the bin from the start to the nearest bin.
    $dist = $distances[$start_node_id][$nearest_node_id];

    for($i = 0; $i < count($unvisited_bins); $i++) {

        // Get the bin at ith index.
        $bin = $unvisited_bins[$i];

        // If a shortest distance bin is found then update the nearest bin.
        if($distances[$start_node_id][$bin_mapping[$bin]] < $dist) {
            $nearest = $bin;
            $nearest_node_id = $bin_mapping[$nearest];
            $dist = $distances[$start_node_id][$nearest_node_id];
        }
    }

    return $nearest;
}

// Instantiate the graph.
$graph = new Graph ( $num_nodes );

// Setup the graph by adding edges and nodes.
foreach ($edges as $edge) {
    $graph->addEdge ( $edge[0], $edge[1] );
}

// Get all the bins.
$bins = array_keys( $bin_mapping );
$bins = array_diff( $bins, ['start'] );

// Initialize the Sylvance class object.
$sylvane = new Sylvane( $bins );

// Get 12 random bins.
$random_bins = $sylvane->getRandomBins ( 12 );

// Instantiate the PathFinder class object.
$path_finder = new PathFinder ( $graph );

// Get all distances.
$distances = $path_finder->getDistances();

// Get all paths.
$paths = $path_finder->getPaths();


// Initally no bin is visited.
$visited = [];

// Start from the start position in the warehouse.
$current_node = 'start';

// Store the final path.
$final_path = ['start'];

// Store the path in the graph with node ids.
$exact_path = [14];

while(count($visited) <= 12) {

    if(count($visited) < 12) {
        // Get the nearest bin.
        $nearest = getNearestBin($current_node, $random_bins, $visited, $distances, $bin_mapping);
    } else {
        $nearest = 'start';
    }

    // Mark the nearest bin as visited.
    $visited[] = $nearest;

    // Get the path from the current node to the nearest bin.
    $current_path = $paths[$bin_mapping[$current_node]][$bin_mapping[$nearest]];

    // Add the path to the exact path.
    for($i = 1; $i < count($current_path); $i++) {
        $exact_path[] = $current_path[$i];
    }

    // Update the current node.
    $current_node = $nearest;

    // Add the nearest bin to the final path.
    $final_path[] = $nearest;
    // echo $current_node . "\n";
}

// $current_path = $paths[$bin_mapping[$current_node]][$bin_mapping['start']];

// for($i = 1; $i < count($current_path); $i++) {
//     $exact_path[] = $current_path[$i];
// }

// $final_path[] = 'start';


// $current_node = 'start';
// $visited = ['start'];

// $next_node = $random_bins[0];
// $next_node_dist = PHP_INT_MAX;

// for($i = 0; $i <= 12; $i++) {

//     $current_node_id = $bin_mapping[$current_node];
//     $next_node_id = $bin_mapping[$next_node];

//     echo $current_node_id . "\n";
//     foreach($random_bins as $bin) {

//         $dist = $distances[$current_node_id][$bin_mapping[$bin]];
//         // echo $current_node_id . ' -> '. $bin_mapping[$bin];

//         if(!in_array($bin, $visited)) {
//             $visited[] = $bin;


//             // echo $bin . ' : '. $dist . ' : ' . $next_node_dist . "\n";
//             if($dist < $next_node_dist) {
//                 $next_node_dist = $dist;
//                 $next_node = $bin;
//                 echo $bin . " : updated";
//             }
//         }
//     }

//     if($i == 12) {
//         $final_path[] = 'start';
//         // $distances[$bin_mapping[$next_node]][$bin_mapping['start']];
//     } else {
//         $final_path[] = $next_node;
//     }

//     $current_node = $next_node;

// }

echo "Random Bins selected are:\n---\n";
foreach($random_bins as $bin) {
    echo $bin . "\n";
}

echo "\n\nThe optimal bin visiting order is as follows:\n---\n";

$i = 0;

foreach($final_path as $bin) {
    echo $bin;

    if($i == count($final_path) - 1) {
        echo "\n";
    } else {
        echo " -> ";
    }

    $i++;

}

echo "\n\nThe exact path in the graph is as follows:\n---\n";

$i = 0;

foreach($exact_path as $node) {
    echo $node;

    if($i == count($exact_path) - 1) {
        echo "\n";
    } else {
        echo " -> ";
    }

    $i++;

}

// echo "The bin"
// print_r($random_bins);
// print_r($final_path);
// print_r($exact_path);
// print_r ( $paths );
// print_r ( $distances );
