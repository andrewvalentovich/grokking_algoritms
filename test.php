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

function search($graph, $search, $destination)
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

    // это требуется для записи обратного пути от каждого узла
    $path = [];
    $path[$search] = new SplDoublyLinkedList();
    $path[$search]->setIteratorMode(
        SplDoublyLinkedList::IT_MODE_FIFO|SplDoublyLinkedList::IT_MODE_KEEP
    );

    $path[$search]->push($search);

    // пока очередь не пуста и путь не найден
    while (!$queue->isEmpty() && $queue->bottom() != $destination) {
        $person = $queue->dequeue(); // в переменную $person присваиваем удалённый из очереди элемент

        if (!empty($graph[$person])) {
            foreach ($graph[$person] as $vertex) {
                if (!$visited[$vertex]) {
                    if ($vertex == $destination) {           // Проверка на продавца
                        echo "Найден $vertex - продавец\n";
                    }
                    // если все еще не посещен, то добавим в очередь и отметим
                    $queue->enqueue($vertex);
                    $visited[$vertex] = true;

                    // добавим узел к текущему пути
                    $path[$vertex] = clone $path[$person];
                    $path[$vertex]->push($vertex);
                }
            }
        }
    }

    if (isset($path[$destination])) {
        echo "из $search в $destination за ",
            count($path[$destination]) - 1,
        " прыжков";
        $sep = '';
        echo " ";
        foreach ($path[$destination] as $vertex) {
            echo $sep, $vertex;
            $sep = '->';
        }
        echo "\n";
    }
    else {
        echo "Нет пути из $search в $destination \n";
    }
}

search($graph, "you", "thom");