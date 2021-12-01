<?php

$inputs = explode("\n", file_get_contents('input.txt'));

$cnt = 0;
$last = PHP_INT_MAX;
foreach ($inputs as $number) {
    if ($number > $last) $cnt++;
    $last = $number;
}

echo $cnt;