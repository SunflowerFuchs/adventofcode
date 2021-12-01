<?php

$inputs = explode("\n", file_get_contents('input.txt'));
$inputs = array_map(fn ($input) => (int) $input, $inputs);

$windows = array_fill_keys(range(0, count($inputs)), 0);
foreach ($inputs as $i => $number){
    if (isset($windows[$i])) $windows[$i] += $number;
    if (isset($windows[$i - 1])) $windows[$i - 1] += $number;
    if (isset($windows[$i - 2])) $windows[$i - 2] += $number;
}

$cnt = 0;
$last = PHP_INT_MAX;
foreach ($windows as $window){
    if ($window > $last) $cnt++;
    $last = $window;
}

echo $cnt;