<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$valid = 0;
foreach ($inputs as $check) {
    preg_match('/^(?<pos1>\d+)-(?<pos2>\d+) (?<letter>\w+): (?<password>.+)$/', $check, $matches);
    $pos1 = substr($matches['password'], $matches['pos1'] - 1, 1);
    $pos2 = substr($matches['password'], $matches['pos2'] - 1, 1);
    if ($pos1 === $matches['letter'] xor $pos2 === $matches['letter']) {
        $valid++;
    }
}

echo $valid . PHP_EOL;