<?php

[$rawBoxLines, $rawMoveLines] = explode("\n\n", trim(file_get_contents(__DIR__ . '/input.txt')));

$boxLines = array_reverse(explode("\n", $rawBoxLines));
$towers = array_fill_keys(array_filter(explode(' ', array_splice($boxLines, 0, 1)[0])), []);

foreach ($boxLines as $line){
    for ($index = 1; $index <= count($towers); $index++){
        $box = substr($line, ($index * 4) - 3, 1);
        if (!trim($box)) continue;

        $towers[$index][] = $box;
    }
}

$moveLines = explode("\n", $rawMoveLines);
foreach ($moveLines as $moveLine) {
    $params = explode(' ', $moveLine);
    [$amount, $from, $to] = [$params[1], $params[3], $params[5]];

    $towers[$to] = array_merge($towers[$to], array_splice($towers[$from], count($towers[$from]) - $amount,$amount));
}

// Print highest boxes
foreach ($towers as $tower) {
    $last = $tower[array_key_last($tower)];
    echo $last;
}
echo "\n";