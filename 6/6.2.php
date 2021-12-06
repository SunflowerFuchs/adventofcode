<?php

$fish = array_map(fn (string $num) => (int)$num, explode(",", file_get_contents('input.txt')));
$ages = array_map(fn (int $target) => count(array_filter($fish, fn (int $age) => $age === $target)), range(0, 8));
$days = 256;
for ($day = 0; $day < $days; $day++) {
    for($i = 0; $i <= 9; $i++) {
        if($i === 0) {
            $ages[9] = $ages[0];
            $ages[7] += $ages[0];
        } else {
            $ages[$i-1] = $ages[$i];
            unset($ages[$i]);
        }
    }
}

echo array_sum($ages) . PHP_EOL;