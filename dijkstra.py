INF = float('inf');

def shortest_path(graph, start, end):

    def aux(current, visited, dists, parents):
        visited[current] = True

        neighbors = graph[current]

        # Update tentative distances of unvisited neighbors
        for i, d in enumerate(neighbors):
            if visited[i] == True:
                continue

            new_dist = dists[current] + d
            if new_dist < dists[i]:
                dists[i] = new_dist
                parents[i] = current

        # Find the unvisited node with the shortest tentative distance
        candidates = [dists[x] for x, v in enumerate(visited) if v == False]
        shortest = min(candidates)

        shortest_indices = [x 
                            for x, v 
                            in enumerate(visited) 
                            if v == False and dists[x] == shortest]

        next_node = shortest_indices[0]

        if shortest == INF:
            return {
                'distance': INF,
                'path': False
            }

        if shortest == dists[end]:

            # Trace path to start
            trace_node = end

            path = []
            while trace_node != start:
                path.append(trace_node)
                trace_node = parents[trace_node]

            path.append(start)
            path.reverse()

            return {
                'distance': shortest,
                'path': path
            }

        return aux(next_node, visited, dists, parents)
    
    
    # Initial values
    visited = [False for _ in range(len(graph))]

    dists = [INF for _ in range(len(graph))]
    dists[start] = 0;

    parents = [None for _ in range(len(graph))]

    return aux(start, visited, dists, parents)
