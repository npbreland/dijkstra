<?php

/**
 * Returns the shortest path between two nodes in a weighted, directed graph
 * and its distance.
 *
 * @param array $graph // Adjacency list representation of the graph
 * @param int $start
 * @param int $end
 *
 * @return array [ path, distance ]
 */
function shortestPath(array $graph, int $start, int $end): array
{
    // Local helper function for recursion
    $aux = function (
        int $currentNode,
        array $visited,
        array $dists, // Tentative distances from start
        array $parents // Parent nodes for each node
    ) use ($graph, $start, $end, &$aux): array {
        $visited[$currentNode] = true;

        // Update tentative distances and parents if the new distance is shorter
        $neighbors = array_filter($graph[$currentNode], function ($weight) {
            return $weight !== INF && $weight > 0;
        });
        $unvisited = array_filter($visited, function ($hasVisited) {
            return $hasVisited === false;
        });
        $unvisitedNeighbors = array_intersect_key($neighbors, $unvisited);
        foreach ($unvisitedNeighbors as $node => $weight) {
            $newDist = $dists[$currentNode] + $weight;
            if ($newDist < $dists[$node]) {
                $dists[$node] = $newDist;
                $parents[$node] = $currentNode;
            }
        }

        // Find the unvisited node with the shortest tentative distance
        $candidates = array_intersect_key($dists, $unvisited);
        $minDist = min($candidates);
        $nextNode = array_search($minDist, $candidates);

        // There is no path to the end
        if ($minDist === INF) {
            return [
                'path' => false,
                'distance' => INF,
            ];
        }

        // We could choose the end as the next node, so we are done
        if ($dists[$end] === $minDist) {
            // Trace the path back to the start
            $path = [];
            $traceNode = $end;
            while ($traceNode !== $start) {
                $path[] = $traceNode;
                $traceNode = $parents[$traceNode];
            }

            $path[] = $start;

            return [
                'path' => array_reverse($path),
                'distance' => $dists[$end],
            ];
        }

        // Otherwise continue to the next node
        return $aux($nextNode, $visited, $dists, $parents);
    };

    $visited = array_fill(0, count($graph), false);

    $dists = array_fill(0, count($graph), INF);
    $dists[$start] = 0;

    $parents = array_fill(0, count($graph), null);
    return $aux($start, $visited, $dists, $parents);
}
