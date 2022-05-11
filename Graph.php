<?php

class Graph {

    /**
     * Number of nodes in the graph.
     *
     * @var int
     */
    private int $num_nodes;

    /**
     * The graph adjacency list.
     *
     * @var array
     */
    private array $graph;

    /**
     * Initialize the object.
     *
     * @param int $num_nodes
     *   Number of nodes in the graph.
     */
    public function __construct ( int $num_nodes ) {

        // Set the number of nodes.
        $this->num_nodes = $num_nodes;

        // Initialize the graph.
        $this->graph = [];

        for( $i = 0; $i < $num_nodes; $i++ ) {
            $this->graph[] = [];
        }
    }

    /**
     * Returns the number of nodes in the graph.
     *
     * @return int
     */
    public function getNumNodes () : int {
        return $this->num_nodes;
    }

    /**
     * Adds an edge to the graph from u to v.
     *
     * @param int $u
     *   Source node
     *
     * @param int $v
     *   Destination node.
     *
     * @return void
     */
    public function addEdge ( int $u, int $v ) : void {

        // Add bidirectional edge.
        $this->graph[$u][] = $v;
        $this->graph[$v][] = $u;
    }

    /**
     * Returns the graph array.
     *
     * @return array
     */
    public function getGraph () : array {
        return $this->graph;
    }

}
