<?php

require_once 'helpers.php';

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
//$inputs = ['acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab | cdfeb fcadb cdfeb cdbaf'];

$count = 0;
foreach ($inputs as $set) {
    [$numbers, $target] = array_map(fn($array) => array_filter(explode(' ', $array)), explode('|', $set));
    $numbers = array_map('sortString', $numbers);
    $target = array_map('sortString', $target);

    $count += count(array_filter($target, fn ($wires) => strlen($wires) < 5 || strlen($wires) === 7));
}

echo $count . PHP_EOL;
