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
            $match = $current_col == $col || ($current_col + 1) == $col || ($current_col - 1) == $col;
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

$matrix[0] = [3,0,0,0];
$matrix[1] = [7,4,0,0];
$matrix[2] = [2,4,6,0];
$matrix[3] = [5,5,9,3];

print_r(main($matrix) . PHP_EOL);


$matrix[0]  = [75,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[1]  = [95,64,0,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[2]  = [17,47,82,0,0,0,0,0,0,0,0,0,0,0,0];
$matrix[3]  = [18,35,87,10,0,0,0,0,0,0,0,0,0,0,0];
$matrix[4]  = [20,04,82,47,65,0,0,0,0,0,0,0,0,0,0];
$matrix[5]  = [19,01,23,75,03,34,0,0,0,0,0,0,0,0,0];
$matrix[6]  = [88,02,77,73,07,63,67,0,0,0,0,0,0,0,0];
$matrix[7]  = [99,65,04,28,06,16,70,92,0,0,0,0,0,0,0];
$matrix[8]  = [41,41,26,56,83,40,80,70,33,0,0,0,0,0,0];
$matrix[9]  = [41,48,72,33,47,32,37,16,94,29,0,0,0,0,0];
$matrix[10] = [53,71,44,65,25,43,91,52,97,51,14,0,0,0,0];
$matrix[11] = [70,11,33,28,77,73,17,78,39,68,17,57,0,0,0];
$matrix[12] = [91,11,52,38,17,14,91,43,58,50,27,29,48,0,0];
$matrix[13] = [63,66,04,68,89,53,67,30,73,16,69,87,40,31,0];
$matrix[14] = [04,62,98,27,23,09,70,28,73,93,38,53,60,04,23];

print_r(main($matrix) . PHP_EOL);




