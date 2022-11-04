<?php

function binary_search($list, $item)
{
    $low = 0;
    $high = count($list) - 1;

    while ($low <= $high) {
        $mid = floor(($low + $high)/2);
        $guess = $list[$mid];

        if ($guess === $item) { // Если средний элемент массива есть искомое значение, то возвращаем его индекс
            return $mid;
        }

        if ($guess > $item) {
            $high = $mid - 1;
        }

        else {
            $low = $mid + 1;
        }
        
    }

    return 0;
}

$my_list = [1, 3, 5, 7, 9];
print_r(binary_search($my_list, 7));