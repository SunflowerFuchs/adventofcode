<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$lines = explode("\n", $input);

$elves = [];
$index = 0;
foreach ($lines as $line) {
    if ($line === '') {
        $index++;
        continue;
    }

    $elves[$index] = ($elves[$index] ?? 0) + (int)$line;
}

// Max elf calories
printf("Max one elf: %d\n", max($elves));

rsort($elves);

printf("Max three elves: %d (%d, %d, %d)\n", ($elves[0] + $elves[1] + $elves[2]), $elves[0], $elves[1], $elves[2]);