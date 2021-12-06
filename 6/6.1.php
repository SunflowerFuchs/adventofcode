<?php


$fish = array_map(fn (string $num) => (int)$num, explode(",", file_get_contents('input.txt')));
$days = 80;
for ($day = 0; $day < $days; $day++) {
    foreach ($fish as &$age) {
        if ($age == 0) {
            $age = 7;
            $fish[] = 9;
        }

        $age--;
    }
}

echo count($fish) . PHP_EOL;