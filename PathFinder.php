<?php

class PathFinder {

    /**
     * The graph class object.
     *
     * @var Graph
     */
    private Graph $graph;

    /**
     * Stores the distance between the two nodes.
     *
     * @var array
     */
    private array $distances;

    /**
     * Stores the path between two nodes.
     *
     * @var array
     */
    private array $paths;

    /**
     * Initialize the object.
     *
     * @param Graph $graph
     *   The instance of the graph class.
     */
    public function __construct ( Graph $graph ) {
        $this->graph = $graph;
        $this->distances = [];
        $this->paths = [];
    }

    /**
     * Returns the shortest path from the source to destination/sink. This method
     * uses the Modified Breadth-First Search (BFS) to find the shortest path
     * from source to sink.
     *
     * @param int $source
     *   The source node.
     *
     * @param int $sink
     *   The destination node.
     *
     *
     * @return array
     */
    public function getShortestPath ( int $source, int $sink ) {

        // Initialize the queue.
        $queue = [];

        // Add the source node to the queue.
        $queue[] = [$source];

        // Mark the source node as visited.
        $visited = [$source];

        // Intially there is no shortest path.
        $shortest_path = [];

        // Set the shortest distance to the maximum integer value.
        $shortest_path_distance = PHP_INT_MAX;

        // Get the graph as the array from the Graph class.
        $graph_array = $this->graph->getGraph();

        while ( count($queue) > 0 ) {

            // Remove the first path from the queue.
            $path = array_shift ( $queue );

            // Get the last node in the removed path.
            $node = $path[ count ( $path ) - 1 ];

            // Update the shortest path and it's distance if it's the best.
            if ( $node == $sink && count ( $path ) < $shortest_path_distance ) {

                // Update the shortest path.
                $shortest_path = $path;

                // Update the shortest path distance.
                $shortest_path_distance = count ( $path );
            }

            // Check all the adjacent/neighboring nodes.
            foreach ( $graph_array[$node] as $adjacent_node ) {

                // If the adjacent node is not visited then add it to the path.
                if( ! in_array ( $adjacent_node, $visited ) ) {

                    // Mark the adjacent node as visited.
                    $visited[] = $adjacent_node;

                    // Get the new path.
                    $new_path = $path;

                    // Add the current adjacent node to the new path.
                    $new_path[] = $adjacent_node;

                    // Push the new path to the queue.
                    $queue[] = $new_path;
                }
            }
        }

        return $shortest_path;
    }

    /**
     * This method finds all the path between all nodes.
     *
     * @return void
     */
    public function findPathsBetweenAllNodes() {

        if ( count($this->distances) > 0 ) {
            return;
        }

        for ( $i = 0; $i < $num_nodes; $i++ ) {

            // Add empty list to the ith node.
            $this->distances[] = [];
            $this->paths[] = [];

            for ( $j = 0; $j < $num_nodes; $j++ ) {

                // Initially set distance to 0 and path to the empty array.
                $this->distances[$i][] = 0;
                $this->paths[$i][] = [];
            }
        }

        for ( $u = 0; $u < $num_nodes; $u++ ) {

            for ( $w = 0; $w < $num_nodes; $w++ ) {

                if ( $u == $w ) {
                    continue;
                }

                // Get the shortest path.
                $path = $path_finder->getShortestPath ( $u, $w );

                // Add the path and it's distance.
                $this->paths[$u][$w] = $path;
                $this->distances[$u][$w] = count ( $path );

            }
        }

    }

    /**
     * Returns the distance between every two nodes.
     *
     * @return array
     */
    public function getDistances() {
        $this->findPathsBetweenAllNodes();

        return $this->distances;
    }

    /**
     * Returns the path between every two nodes.
     *
     * @return array
     */
    public function getPaths() {
        $this->findPathsBetweenAllNodes();

        return $this->paths;
    }

}
