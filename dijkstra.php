<?php

/**
 * Returns the shortest path between two nodes in a graph.
 *
 * @param array $graph
 * @param int $start
 * @param int $end
 *
 * @return array|false Return false if there is no path between the two nodes.
 */

// Tests

/**
  * Adjacency matrix:
  * 0 denotes that it is the same node
  * INF denotes that there is no direct path
 */
$graph1 = [
    [ 0, 1, 1, INF, INF, INF ],
    [ INF, 0, INF, INF, 2, INF ],
    [ INF, INF, 0, 1, INF, INF ],
    [ INF, INF, INF, 0, INF, 1 ],
    [ INF, INF, INF, INF, 0, 1 ],
    [ INF, INF, INF, INF, INF, 0 ]
];

$graph2 = [
    [ 0 , 1, INF, 1, INF, INF, 1, 1, INF, INF, INF ],
    [ INF , 0, 1, INF, INF, INF, INF, INF, INF, INF, INF ],
    [ INF, INF, 0, INF, INF, INF, INF, INF, INF, INF, INF ],
    [ INF, INF, INF, 0, 1, INF, INF, INF, INF, INF, INF ],
    [ INF, INF, INF, INF, 0, 1, INF, INF, INF, INF, INF ],
    [ INF, INF, INF, INF, INF, 0, INF, INF, INF, INF, INF],
    [ INF, INF, INF, INF, INF, INF, 0, 1, INF, INF, INF ],
    [ INF, INF, INF, INF, INF, INF, INF, 0, 1, INF, INF ],
    [ INF, INF, INF, INF, INF, INF, INF, INF, 0, 1, INF ],
    [ INF, INF, INF, INF, INF, 1, INF, INF, INF, 0, 1 ],
    [ INF, INF, INF, INF, INF, INF, INF, INF, INF, INF, 0 ],
];

echo(shortestPath($graph1, 0, 5) === [0, 2, 3, 5] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph1, 1, 5) === [1, 4, 5] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph1, 2, 5) === [2, 3, 5] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 0, 5) === [0, 3, 4, 5] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 1, 5) === false ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 2, 5) === false ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 3, 5) === [3, 4, 5] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 6, 10) === [6, 7, 8, 9, 10] ? 'Pass' : 'Fail') . PHP_EOL;
echo(shortestPath($graph2, 7, 10) === [7, 8, 9, 10] ? 'Pass' : 'Fail') . PHP_EOL;

function shortestPath(array $graph, int $start, int $end): array|false
{
    $aux = function (
        int $nodeKey, // Key of current node (CPA)
        array $visited, // Keys of visited nodes (CPA)
        array $paths, // Paths from start to end (RSFA), pruned if incomplete
        int $pathKey, // Key of current path (CPA)
        array $dists // Distances from start to end (CPA)
    ) use ($graph, $start, $end, &$aux): array|false {
        // Node relationships to the current node
        $nodes = $graph[$nodeKey];

        /* Mark that we have visited this node. Exclude end because we may need
        to visit it multiple times */
        if (!in_array($nodeKey, $visited) && $nodeKey !== $end) {
            $visited[] = $nodeKey;
        }

        // Get unvisited nodes that are connected to current node (candidates)
        $unvisited =  array_filter($nodes, function ($nodeKey) use ($visited) {
            return !in_array($nodeKey, $visited);
        }, ARRAY_FILTER_USE_KEY);

        $candidates = array_filter($unvisited, function ($weight) {
            return $weight !== INF && $weight > 0;
        });

        if (count($candidates) === 0) {
            if ($nodeKey === $start) {
                // No more candidates from start. We are done.
                if (count($paths) === 0) {
                    return false;
                }

                // Return the shortest path
                $min = min($dists);
                $minKey = array_search($min, $dists);
                // Append the end node so we have the full path
                return array_merge($paths[$minKey], [$end]);
            } elseif ($nodeKey === $end) {
                // We've completed a path. Start over on a new path.
                $pathKey++;
            } else {
                /* We didn't reach the end. Prune the path and remove the nodes
                from the visited list except for the final one */
                foreach ($paths[$pathKey] as $node) {
                    $visited = array_diff($visited, [$node]);
                }
                unset($paths[$pathKey]);
                unset($dists[$pathKey]);
            }

            return $aux($start, $visited, $paths, $pathKey, $dists);
        }

        // We have candidates. Choose the shortest path.
        $min = min($candidates);

        // Keep track of the total distance of the current path
        if (!isset($dists[$pathKey])) {
            $dists[$pathKey] = 0;
        }
        $dists[$pathKey] += $min;
        $paths[$pathKey][] = $nodeKey;

        $nextKey = array_search($min, $candidates);
        return $aux($nextKey, $visited, $paths, $pathKey, $dists);
    };

    return $aux($start, [], [], 0, []);
}
