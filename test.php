<?php

// Поиск в ширину

$graph = [
    'you' => ['alice', 'bob', 'claire'],
    'bob' => ['anuj', 'peggy'],
    'alice' => ['peggy'],
    'claire' => ['thom', 'jonny'],
    'anuj' => [],
    'peggy' => [],
    'thom' => [],
    'jonny' => [],
];

function search($graph, $search)
{
    $visited = [];

    // пустая очередь
    $queue = new SplQueue();

    // пометим все узлы как непосещенные
    foreach ($graph as $vertex=>$neighbor) {
        $visited[$vertex] = false;
    }

    // добавим начальную вершину в очередь и пометим ее как посещенную
    $queue->enqueue($search);
    $visited[$search] = true;

    // пока очередь не пуста и путь не найден
    while (!$queue->isEmpty()) {
        $person = $queue->dequeue(); // в переменную $person присваиваем удалённый из очереди элемент

        if (!empty($graph[$person])) {
            print_r($graph[$person]);
            foreach ($graph[$person] as $vertex) {
                if (!$visited[$vertex]) {
                    if ($vertex == "jonny") {           // Проверка на продавца
                        echo "Найден $vertex - продавец\n";
                        return true;
                    }
                    // если все еще не посещен, то добавим в очередь и отметим
                    $queue->enqueue($vertex);
                    $visited[$vertex] = true;
                }
            }
        }
    }
}

search($graph, 'you');