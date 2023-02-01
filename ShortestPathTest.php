<?php

require_once 'vendor/autoload.php';
require_once 'dijkstra.php';

final class ShortestPathTest extends PHPUnit\Framework\TestCase
{
    /**
      * These graphs are adjacency matrices.
      * 0 denotes that it is the same node
      * INF denotes that there is no direct path.
     */
    private $graph1 = [
        [ 0, 1, 1, INF, INF, INF ],
        [ INF, 0, INF, INF, 2, INF ],
        [ INF, INF, 0, 1, INF, INF ],
        [ INF, INF, INF, 0, INF, 1 ],
        [ INF, INF, INF, INF, 0, 1 ],
        [ INF, INF, INF, INF, INF, 0 ]
    ];

    private $graph2 = [
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

    public function testPaths()
    {
        $this->assertSame([0, 2, 3, 5], shortestPath($this->graph1, 0, 5)['path']);
        $this->assertSame([1, 4, 5], shortestPath($this->graph1, 1, 5)['path']);
        $this->assertSame([2, 3, 5], shortestPath($this->graph1, 2, 5)['path']);

        $this->assertSame([0, 3, 4, 5], shortestPath($this->graph2, 0, 5)['path']);
        $this->assertSame(false, shortestPath($this->graph2, 1, 5)['path']);
        $this->assertSame(false, shortestPath($this->graph2, 2, 5)['path']);
        $this->assertSame([3, 4, 5], shortestPath($this->graph2, 3, 5)['path']);
        $this->assertSame([6, 7, 8, 9, 10], shortestPath($this->graph2, 6, 10)['path']);
        $this->assertSame([7, 8, 9, 10], shortestPath($this->graph2, 7, 10)['path']);
    }

    public function testDistances()
    {
        $this->assertSame(3, shortestPath($this->graph1, 0, 5)['distance']);
        $this->assertSame(3, shortestPath($this->graph1, 1, 5)['distance']);
        $this->assertSame(2, shortestPath($this->graph1, 2, 5)['distance']);

        $this->assertSame(3, shortestPath($this->graph2, 0, 5)['distance']);
        $this->assertSame(INF, shortestPath($this->graph2, 1, 5)['distance']);
        $this->assertSame(INF, shortestPath($this->graph2, 2, 5)['distance']);
        $this->assertSame(2, shortestPath($this->graph2, 3, 5)['distance']);
        $this->assertSame(4, shortestPath($this->graph2, 6, 10)['distance']);
        $this->assertSame(3, shortestPath($this->graph2, 7, 10)['distance']);
    }
}
