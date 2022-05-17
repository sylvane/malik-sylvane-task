
# Sylvane Task

This is a task to find the shortest path by visiting all the bins in the warehouse and coming back to the start position in an optimal way.

## Approach

1. We are considering the aisle as the nodes in the graph and when we are at a certain aisle we can pick the item from the bin on either side of the aisle.
2. The Modified Breadth-First Search is used to find the shortest path from all pairs of nodes in the graph.
3. Starting with the start position this approach greedily picks the nearst node from the start position and then takes the path and then from there picks the next nearsest node until all the bins are visited.
4. Finally, it returns back to the start position.

The graph of the warehouse is as follows:
![WareHouse Visualization](https://github.com/maliknaik16/sylvane-task/raw/master/Warehouse.png)

In the above graph, the green nodes are the aisles and are paths that can be traversed and the white nodes are the bins from which we can pick the items.

## Execution

To test the working of this code. Clone this repository and then run the following command:
```
php main.php {aisle_bin_count} {A1,B2,C3}
```

Make sure you have PHP CLI installed before running the above command.

## Visualization

To execute the visualization using Python you need to install the `NetworkX` and `Matplotlib` libraries. They can be installed by running the following command:

```
python -m pip install -r requirements.txt
```

Then, run the following command to generate the visualization of the Warehouse.

```
python visualization.py {aisle_bin_count}
```


