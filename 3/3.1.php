<?php

$inputs = explode("\n", file_get_contents('input.txt'));
$length = array_reduce($inputs, fn(int $carry, string $bin) => max(strlen($bin), $carry), 0);

$positions = array_fill_keys(range(0, $length - 1), 0);
foreach ($inputs as $bin) {
    foreach ($positions as $position => &$sum) {
        $sum += (int)substr($bin, $position, 1);
    }
}

$gamma = '';
foreach ($positions as $position => $sum) {
    $gamma .= round($sum / count($inputs));
}

$epsilon = bindec(strtr($gamma, ['1' => '0', '0' => '1']));
$gamma = bindec($gamma);

echo $gamma . PHP_EOL;
echo $epsilon . PHP_EOL;
echo ($gamma * $epsilon) . PHP_EOL;