<?php

$inputs = array_map(fn($num) => (int)$num, array_filter(explode("\n", file_get_contents('input.txt'))));

for ($i = 0; $i < count($inputs) - 2; $i++) {
    for ($j = $i + 1; $j < count($inputs) - 1; $j++) {
        for ($k = $j + 1; $k < count($inputs); $k++) {
            if ($inputs[$i] + $inputs[$j] + $inputs[$k] === 2020) {
                echo ($inputs[$i] * $inputs[$j] * $inputs[$k]) . PHP_EOL;
            }
        }
    }
}