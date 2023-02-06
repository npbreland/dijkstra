import unittest
import dijkstra

INF = dijkstra.INF

class ShortestPathTest(unittest.TestCase):

    graph1 = [
        [ 0, 1, 1, INF, INF, INF ],
        [ INF, 0, INF, INF, 2, INF ],
        [ INF, INF, 0, 1, INF, INF ],
        [ INF, INF, INF, 0, INF, 1 ],
        [ INF, INF, INF, INF, 0, 1 ],
        [ INF, INF, INF, INF, INF, 0 ]
    ];

    graph2 = [
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

    def test_paths(self):
        self.assertEqual([0, 2, 3, 5], dijkstra.shortest_path(self.graph1, 0, 5)['path'])
        self.assertEqual([1, 4, 5], dijkstra.shortest_path(self.graph1, 1, 5)['path'])
        self.assertEqual([2, 3, 5], dijkstra.shortest_path(self.graph1, 2, 5)['path'])

        self.assertEqual([0, 3, 4, 5], dijkstra.shortest_path(self.graph2, 0, 5)['path'])
        self.assertEqual(False, dijkstra.shortest_path(self.graph2, 1, 5)['path'])
        self.assertEqual(False, dijkstra.shortest_path(self.graph2, 2, 5)['path'])
        self.assertEqual([3, 4, 5], dijkstra.shortest_path(self.graph2, 3, 5)['path'])
        self.assertEqual([6, 7, 8, 9, 10], dijkstra.shortest_path(self.graph2, 6, 10)['path'])
        self.assertEqual([7, 8, 9, 10], dijkstra.shortest_path(self.graph2, 7, 10)['path'])

    def test_distances(self):
        self.assertEqual(3, dijkstra.shortest_path(self.graph1, 0, 5)['distance'])
        self.assertEqual(3, dijkstra.shortest_path(self.graph1, 1, 5)['distance'])
        self.assertEqual(2, dijkstra.shortest_path(self.graph1, 2, 5)['distance'])

        self.assertEqual(3, dijkstra.shortest_path(self.graph2, 0, 5)['distance'])
        self.assertEqual(INF, dijkstra.shortest_path(self.graph2, 1, 5)['distance'])
        self.assertEqual(INF, dijkstra.shortest_path(self.graph2, 2, 5)['distance'])
        self.assertEqual(2, dijkstra.shortest_path(self.graph2, 3, 5)['distance'])
        self.assertEqual(4, dijkstra.shortest_path(self.graph2, 6, 10)['distance'])
        self.assertEqual(3, dijkstra.shortest_path(self.graph2, 7, 10)['distance'])
        
if __name__ == '__main__':
    unittest.main()
