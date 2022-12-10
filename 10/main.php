<?php

$lines = explode("\n", trim(file_get_contents(__DIR__ . '/input.txt')));

$lastValue = 1;
$cycle = 0;
$cycles = [$cycle => $lastValue];
foreach ($lines as $line) {
    $command = explode(' ', $line);
    if ($command[0] === 'noop') {
        $cycles[++$cycle] = $lastValue;
    } elseif ($command[0] === 'addx') {
        $cycles[++$cycle] = $lastValue;
        $cycles[++$cycle] = ($lastValue += intval($command[1]));
    }
}

$totalValue = 0;
for ($i = 20; $i < count($cycles); $i += 40) {
    printf("Counter at the beginning of the %dth cycle: %d\n", $i, $cycles[$i - 1]);
    $totalValue += $cycles[$i - 1] * $i;
}
printf("Final counter sum: %d\n\n\n", $totalValue);

foreach ($cycles as $cycle => $value) {
    $out = '.';
    if (abs($cycle % 40 - $value) <= 1) {
        $out = '#';
    }

    printf('%s%s', $out, $cycle % 40 === 39 ? "\n" : '');
}