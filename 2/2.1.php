<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$valid = 0;
foreach ($inputs as $check) {
    preg_match('/^(?<min>\d+)-(?<max>\d+) (?<letter>\w+): (?<password>.+)$/', $check, $matches);
    $cnt = preg_match_all("/{$matches['letter']}{1}/", $matches['password']);
    if ($cnt <= $matches['max'] && $cnt >= $matches['min']) {
        $valid++;
    }
}

echo $valid . PHP_EOL;