<?php

// Алгоритм Дейкстры

$graph = [
    'A' => [
        'B' => 3,
        'D' => 3,
        'F' => 6
    ],
    'B' => [
        'A' => 3,
        'D' => 1,
        'E' => 3
    ],
    'C' => [
        'E' => 2,
        'F' => 3
    ],
    'D' => [
        'A' => 3,
        'B' => 1,
        'E' => 1,
        'F' => 2
    ],
    'E' => [
        'B' => 3,
        'C' => 2,
        'D' => 1,
        'F' => 5
    ],
    'F' => [
        'A' => 6,
        'C' => 3,
        'D' => 2,
        'E' => 5
    ],
];

class Dijkstra
{
    protected $graph;

    public function __construct($graph) {
        $this->graph = $graph;
    }

    public function shortestPath($source, $target) {
        // массив кратчайших путей к каждому узлу
        $shortedPath = [];
        // массив "предшественников" для каждого узла
        $knotParent = [];
        // очередь всех неоптимизированных узлов
        $knotQueue = new SplQueue();

        foreach ($this->graph as $knot => $value) { // knot - узел ("A", "B", "C"... , "F"), value - массив соседей узла
            $shortedPath[$knot] = INF; // устанавливаем изначальные расстояния как бесконечность
            $knotParent[$knot] = null; // никаких узлов позади нет
            foreach ($value as $neighbor => $cost) { // записываем в очередь всех соседей каждого из узлов ("A", "B", "C"... , "F")
                $knotQueue->enqueue($neighbor);
            }
        }

        // начальная дистанция на стартовом узле - 0
        $shortedPath[$source] = 0;

        while (!$knotQueue->isEmpty()) { // Пока есть очередь из узлов
            // извлечем минимальную цену
            $nearest_neighbor = $knotQueue->dequeue();
            if (!empty($this->graph[$nearest_neighbor])) {
                // пройдемся по всем соседним узлам
                foreach ($this->graph[$nearest_neighbor] as $neighbor => $cost) {
                    // установим новую длину пути для соседнего узла
                    $alt = $shortedPath[$nearest_neighbor] + $cost;

                    // если он оказался короче
                    if ($alt < $shortedPath[$neighbor]) {
                        $shortedPath[$neighbor] = $alt; // установим как минимальное расстояние до этого узла
                        $knotParent[$neighbor] = $nearest_neighbor;  // добавим соседа как предшествующий этому узел
                    }
                }
            }
        }

        // теперь мы можем найти минимальный путь
        // используя обратный проход
        $stack = new SplStack(); // кратчайший путь как стек
        $finish_target = $target;
        $distance = 0;
        // проход от целевого узла до стартового
        while (isset($knotParent[$finish_target]) && $knotParent[$finish_target]) {
            $stack->push($finish_target);
            $distance += $this->graph[$finish_target][$knotParent[$finish_target]]; // добавим дистанцию для предшествующих
            $finish_target = $knotParent[$finish_target];
        }

        // стек будет пустой, если нет пути назад
        if ($stack->isEmpty()) {
            echo "Нет пути из $source в $target \n";
        }
        else {
            // добавим стартовый узел и покажем весь путь
            // в обратном (LIFO) порядке
            $stack->push($source);
            echo "$distance:";
            $sep = '';
            foreach ($stack as $v) {
                echo $sep, $v;
                $sep = '->';
            }
            echo "n";
        }
    }
}

$g = new Dijkstra($graph);

$g->shortestPath('D', 'C');