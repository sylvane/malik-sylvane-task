import matplotlib.pyplot as plt
import networkx as nx
import argparse

parser = argparse.ArgumentParser()
parser.add_argument('aisle_bin_count', type=int)
args = parser.parse_args()

graph = nx.Graph()
# pos = {(0, 0): (0, 0)}
pos = {}

s, e = 1, 0

aisle_bin_count_plus_1 = args.aisle_bin_count + 1
aisle_count = 4
start = [0, (aisle_bin_count_plus_1 * 1) + 1, (aisle_bin_count_plus_1 * 2) + 2, (aisle_bin_count_plus_1 * 3) + 3]
end = [(aisle_bin_count_plus_1 * 1), (aisle_bin_count_plus_1 * 2) + 1, (aisle_bin_count_plus_1 * 3) + 2, (aisle_bin_count_plus_1 * 4) + 3]

for i in range(end[-1]):
    graph.add_node(i)
    graph.add_node(i + 1)

    pos[i] = (s, e)

    if i > 1 and i % (aisle_bin_count_plus_1 + 1) == 0:
        s += 3

    e = (e + 1) % (aisle_bin_count_plus_1 + 1)

    if i > 1 and i in end:
        continue

    graph.add_edge(i, i + 1)
    # pos[(i, i + 1)] = (i + 1, -1 * i)

k = 0
s = 2

for i in range(end[-1] + 1, (end[-1] + 1) + (aisle_count - 1) * 2, 2):
    graph.add_node(i)
    graph.add_node(i + 1)
    graph.add_edge(start[k], i)
    pos[i] = (s, 0)
    pos[i + 1] = (s + 1, 0)
    # pos[(start[k], i)] = (i, -1 * start[k])
    graph.add_edge(i, i + 1)
    # pos[(i, i + 1)] = (i + 1, -1 * i)
    graph.add_edge(i + 1, start[k + 1])
    # pos[(i + 1, start[k + 1])] = (start[k + 1], -1 * (i + 1))

    s += 3
    k += 1

k = 0
e = aisle_bin_count_plus_1
s = 2

for i in range((end[-1] + 1) + (aisle_count - 1) * 2, (end[-1] + 1) + (aisle_count - 1) * 4, 2):
    graph.add_node(i)
    graph.add_node(i + 1)
    graph.add_edge(end[k], i)
    pos[i] = (s, e)
    pos[i + 1] = (s + 1, e)
    # pos[(end[k], i)] = (i, -1 * end[k])
    graph.add_edge(i, i + 1)
    # pos[(i, i + 1)] = (i + 1, -1 * i)
    graph.add_edge(i + 1, end[k + 1])
    # pos[(i + 1, end[k + 1])] = (end[k + 1], -1 * (i + 1))

    s += 3
    k += 1

s = 1
for u in start:
    pos[u] = (s, 0)
    s += 3

s = 1
for u in end:
    pos[u] = (s, aisle_bin_count_plus_1)
    s += 3

pos[end[-1]] = (10, aisle_bin_count_plus_1)

bins = []

s = 0
for i in range(1, aisle_bin_count_plus_1):

    label = 'A' + str(i)
    graph.add_node(label)
    pos[label] = (s, i)
    bins.append(label)

s = 2
for i in range(1, aisle_bin_count_plus_1):

    label1 = 'B' + str(i)
    label2 = 'C' + str(i)

    graph.add_node(label1)
    graph.add_node(label2)
    pos[label1] = (s, i)
    pos[label2] = (s + 1, i)
    bins.append(label1)
    bins.append(label2)

s = 5
for i in range(1, aisle_bin_count_plus_1):

    label1 = 'D' + str(i)
    label2 = 'E' + str(i)

    graph.add_node(label1)
    graph.add_node(label2)
    pos[label1] = (s, i)
    pos[label2] = (s + 1, i)
    bins.append(label1)
    bins.append(label2)

s = 8
for i in range(1, aisle_bin_count_plus_1):

    label1 = 'F' + str(i)
    label2 = 'G' + str(i)

    graph.add_node(label1)
    graph.add_node(label2)
    pos[label1] = (s, i)
    pos[label2] = (s + 1, i)
    bins.append(label1)
    bins.append(label2)

color_map = []

for i in range((end[-1] + 1) + (aisle_count - 1) * 4):
    color_map.append('#e0ecd4')

for i in range(len(pos) - len(color_map)):
    color_map.append('#FFF')
print(pos)

# graph.add_node(0)
# graph.add_node(1)
# graph.add_node(2)
# graph.add_node(3)

# graph.add_edge(0, 1)
# graph.add_edge(1, 2)
# graph.add_edge(2, 3)
# graph.add_edge(3, 0)
print(graph.nodes())
# pos = {(x, y):(y, -x) for x,y in graph.nodes()}

options = {
    "edgecolors": "#333",
    "node_size": 800,
    # "node_color": "#FC5647",
    "node_color": color_map,
    "linewidths": 2,
    "width": 2,
    "edge_color": "#333",
    "font_color": "#212a35",
    "font_size": "11",
    "node_shape": "s"
}

nx.draw(graph, with_labels=True, pos=pos,
**options)#nx.random_layout(graph)) #pos=pos) # nx.spring_layout(graph))
plt.show()

adj_matrix = nx.adjacency_matrix(graph).todense().tolist()
# adj_matrix = adj_matrix.reshape(len(adj_matrix), len(adj_matrix))

edges = []
# print(adj_matrix)
for i in range(len(adj_matrix)):

    for j in range(len(adj_matrix)):

        if adj_matrix[i][j] == 1:
            edges.append((i, j))
    # print(adj_matrix[i])

print(edges)

# edges = []

# for edge in :
#     eg = str(edge)
#     array = eg[:eg.find(')') + 1].strip()
#     print(array)
#     # edges.append(tuple(array))

# print(edges)
# print(nx.adjacency_matrix(graph).toarray())