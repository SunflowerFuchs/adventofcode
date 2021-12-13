<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$seats = [];
foreach ($inputs as $input) {
    $row = bindec(strtr(substr($input, 0, 7), ['F' => 0, 'B' => 1]));
    $column = bindec(strtr(substr($input, 7), ['L' => 0, 'R' => 1]));
    $seats[($row * 8) + $column] = true;
}

foreach ($seats as $seatId => $true) {
    if (!isset($seats[$seatId + 1]) && isset($seats[$seatId + 2])) {
        echo ($seatId + 1) . PHP_EOL;
    }
}