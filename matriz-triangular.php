<?php
function getcol_of_mayor($row) {
    $pos = -1;
    $col = -1;
    $mayor = -100;
    foreach ($row as $value) {
        ++$col;
        if ($value > $mayor) {
            $mayor = $value;
            $pos = $col;
        }
    }

    return $pos;
}

function main($matrix) {
    $sum = 0;
    $current_col = 0;
    foreach ($matrix as $row) {
        do {
            $col = getcol_of_mayor($row);
            $match = $current_col == $col || ($current_col + 1) == $col;/* || ($current_col - 1) == $col;*/
            if ($match) {
                $sum += $row[$col];
                $current_col = $col;
            } else {
                $row[$col] = 0;
            }
        } while (!$match);
    }

    return $sum;
}

function get_children($current_col, $row) {
    $children = [];

    // Array of children for the current mayor every element of the array
    // will be formed by current col position in the matrix and a value
    $children["$current_col"] = $row[$current_col];

    $col = $current_col + 1;
    if (isset($row[$col])) {   // Prevent an out of bound of index
        $children["$col"] = $row[$col];
    }

    return $children;
}

function main_speed_improved($matrix) {
    $sum = $matrix[0][0];
    // Number of columns;
    $cols = count($matrix[0]);
    $rows = $cols;
    $current_col = 0;
    $col = 0;

    for ($i = 1; $i < $rows; $i++) {
        $row = $matrix[$i];

        // Get the mayor of the children
        $mayor = -100;
        $children = get_children($current_col, $row);

        foreach ($children as $key => $value) {
            if ($value > $mayor) {
                $mayor = $value;
                // Set column for the new mayor
                $current_col = $key;
                // If existe 2 child with same value calculate the best route
            } elseif ($value == $mayor && ($i < $rows - 1)) {
                $children1 = get_children($current_col, $matrix[$i + 1]);
                $children2 = get_children($key, $matrix[$i + 1]);
                // Sort the array in reverse order
                rsort($children1, SORT_NUMERIC);
                rsort($children2, SORT_NUMERIC);

                $value1 = reset($children1);
                $value2 = reset($children2);

                if ($value2 > $value1) {
                    $mayor = $value;
                    // Set column for the new mayor
                    $current_col = $key;
                }
            }
        }

        $sum += $mayor;

    }

    return $sum;
}

$matrix[0] = [3,0,0,0];
$matrix[1] = [7,4,0,0];
$matrix[2] = [2,4,6,0];
$matrix[3] = [5,5,9,3];


$time_start = microtime(true);
print_r(main($matrix) . PHP_EOL);
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("Time elapse for main: %.8f", $time), PHP_EOL;

$time_start = microtime(true);
echo main_speed_improved($matrix), PHP_EOL;
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("Time elapse for main_speed_improved: %.8f", $time), PHP_EOL;



$matrix[] = [75,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[] = [95,64,0,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[] = [17,47,82,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[] = [18,35,87,10,0,0,0,0,0,0,0,0,0,0,0];
$matrix[] = [20,04,82,47,65,0,0,0,0,0,0,0,0,0,0];
$matrix[] = [19,01,23,75,03,34,0,0,0,0,0,0,0,0,0];
$matrix[] = [88,02,77,73,07,63,67,0,0,0,0,0,0,0,0];
$matrix[] = [99,65,04,28,06,16,70,92,0,0,0,0,0,0,0];
$matrix[] = [41,41,26,56,83,40,80,70,33,0,0,0,0,0,0];
$matrix[] = [41,48,72,33,47,32,37,16,94,29,0,0,0,0,0];
$matrix[] = [53,71,44,65,25,43,91,52,97,51,14,0,0,0,0];
$matrix[] = [70,11,33,28,77,73,17,78,39,68,17,57,0,0,0];
$matrix[] = [91,11,52,38,17,14,91,43,58,50,27,29,48,0,0];
$matrix[] = [63,66,04,68,89,53,67,30,73,16,69,87,40,31,0];
$matrix[] = [04,62,98,27,23,09,70,98,73,93,38,53,60,04,23];

$time_start = microtime(true);
echo main($matrix), PHP_EOL;
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("Time elapsed for main: %.8f", $time), PHP_EOL;

$time_start = microtime(true);
echo main_speed_improved($matrix), PHP_EOL;
$time_end = microtime(true);
$time = $time_end - $time_start;
echo sprintf("Time elapsed for main_speed_improved: %.8f", $time), PHP_EOL;
