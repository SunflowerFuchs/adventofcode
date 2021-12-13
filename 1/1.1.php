<?php

$inputs = array_map(fn($num) => (int)$num, array_filter(explode("\n", file_get_contents('input.txt'))));

for ($i = 0; $i < count($inputs) - 1; $i++) {
    for ($j = $i + 1; $j < count($inputs); $j++) {
        if ($inputs[$i] + $inputs[$j] === 2020) {
            echo $inputs[$i] * $inputs[$j] . PHP_EOL;
        }
    }
}