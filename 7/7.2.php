<?php

$inputs = explode(',', file_get_contents('input.txt'));

$start = min($inputs);
$end = max($inputs);
$sums = array_fill_keys(range($start, $end), 0);
foreach (range($start, $end) as $pos) {
    foreach ($inputs as $input) {
        $diff = abs($input - $pos);
        if ($diff > 0) {
            $sums[$pos] += array_sum(range(1, $diff));
        }
    }
}

asort($sums);
$smallestPos = array_key_first($sums);

echo "${smallestPos} -> ${sums[$smallestPos]}" . PHP_EOL;