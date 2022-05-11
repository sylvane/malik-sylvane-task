
import matplotlib.pyplot as plt
import networkx as nx
from networkx.drawing.nx_agraph import to_agraph

graph = nx.Graph()
# pos = {(0, 0): (0, 0)}
pos = {}

s, e = 0, 0

start = [0, 13, 26, 39]
end = [12, 25, 38, 51]

for i in range(51):
    graph.add_node(i)
    graph.add_node(i + 1)

    pos[i] = (s, e)

    if i > 0 and i % 13 == 0:
        s += 3

    e = (e + 1) % 13

    if i > 0 and i in end:
        continue

    graph.add_edge(i, i + 1)
    # pos[(i, i + 1)] = (i + 1, -1 * i)

k = 0
s = 1

for i in range(52, 58, 2):
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
e = 12
s = 1

for i in range(58, 64, 2):
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

s = 0
for u in start:
    pos[u] = (s, 0)
    s += 3

s = 0
for u in end:
    pos[u] = (s, 12)
    s += 3

pos[51] = (9, 12)

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
    "node_color": "#FC5647",
    "linewidths": 2,
    "width": 2,
    "edge_color": "#333",
    "font_color": "white",
    "font_size": "11"
}

nx.draw(graph, with_labels=True, pos=pos, **options)#nx.random_layout(graph)) #pos=pos) # nx.spring_layout(graph))
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