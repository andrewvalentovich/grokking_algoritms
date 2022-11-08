<?php

// Алгоритм быстрой сортировки (опорный элемент $pivot является первым из массива $arr)
// В стандартной реализации опорный элемент является средним из массива $arr
// Скорость O(n*log n)

function quicksort($arr)
{
    if (count($arr) < 2) {
        return $arr;
    } else {
        $pivot = $arr[0];
        $less = [];
        $greater = [];
        for ($i = 1; $i < count($arr); $i++) {
            if ($arr[$i] <= $pivot) {
                array_push($less, $arr[$i]);
            }
            if ($arr[$i] > $pivot) {
                array_push($greater, $arr[$i]);
            }
        }
        return array_merge(quicksort($less), [$pivot], quicksort($greater));
    }
}

print_r(quicksort([1, 5, 6, 2, 53, 20, 9, 291, 214, 21, 204, 24, 54, 94, 2303, 4523, 9288, 12, 942, 23]));