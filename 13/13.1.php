<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));
$folds = array_values(array_map(fn($input) => explode('=', substr($input, 11)),
    array_filter($inputs, fn($input) => str_starts_with($input, 'fold'))));

$width = 0;
$height = 0;
$points = [];
foreach (array_filter($inputs, fn($input) => !str_starts_with($input, 'fold')) as $point) {
    [$y, $x] = explode(',', $point);
    $x = (int)$x;
    $y = (int)$y;

    $points[] = ['x' => $x, 'y' => $y];
    $width = max($width, $x);
    $height = max($height, $y);
}

$sheet = array_fill(0, $width + 1, array_fill(0, $height + 1, false));
foreach ($points as ['x' => $x, 'y' => $y]) {
    $sheet[$x][$y] = true;
}

function doFold(array $sheet, string $direction, int $foldLine): array
{
    switch ($direction) {
        case 'y' :
            $baseSheet = $sheet;
            $width = count($sheet[0]);
            $height = ($foldLine * 2) + 1;

            $sheet = [];
            for ($y = 0; $y < $foldLine; $y++) {
                $sheet[$y] = [];
                for ($x = 0; $x < $width; $x++) {
                    $sheet[$y][$x] = ($baseSheet[$y][$x] ?? false) || ($baseSheet[$height - $y - 1][$x] ?? false);
                }
            }
            break;
        case 'x':
            $baseSheet = $sheet;
            $width = ($foldLine * 2) + 1;
            $height = count($sheet);

            $sheet = [];
            for ($y = 0; $y < $height; $y++) {
                $sheet[$y] = [];
                for ($x = 0; $x < $foldLine; $x++) {
                    $sheet[$y][$x] = ($baseSheet[$y][$x] ?? false) || ($baseSheet[$y][$width - $x - 1] ?? false);
                }
            }
            break;
    }

    return $sheet;
}

foreach ($folds as $key => [$direction, $foldLine]) {
    $sheet = doFold($sheet, $direction, $foldLine);
    // First challenge only needs the first fold, so we just break here
    break;
}

$points = array_reduce($sheet,
    fn($carry, $row) => $carry + array_reduce($row, fn($iCarry, $point) => $iCarry + ($point ? 1 : 0), 0), 0);

echo $points . PHP_EOL;