<?php

$rows = array_map(fn (string $line) => array_map(fn ($size) => intval($size), str_split($line)), explode("\n", trim(file_get_contents(__DIR__ . '/input.txt'))));
$columns = array_fill_keys(range(0, count($rows[0]) - 1),  array_fill_keys(range(0, count($rows) - 1), []));
foreach ($rows as $y => $row) {
    foreach ($row as $x => $tree){
        $columns[$x][$y] = $tree;
    }
}

$numVisible = 0;
$topScenicScore = 0;
foreach ($rows as $y => $row) {
    foreach ($row as $x => $curTree) {
        $firstRow = $y === 0;
        $lastRow = $y === count($rows) - 1;
        $firstCol = $x === 0;
        $lastCol = $x === count($row) - 1;
        if ($firstRow || $lastRow || $firstCol || $lastCol) {
            $numVisible++;
            continue;
        }

        $left = array_reverse(array_slice($row, 0, $x));
        $right = array_slice($row, $x+1);
        $up = array_reverse(array_slice($columns[$x], 0, $y));
        $down = array_slice($columns[$x], $y+1);

        $isVisible = false;
        $scenicScore = 1;
        foreach ([$left, $right, $up, $down] as $direction){
            if (!$isVisible && empty(array_filter($direction ,fn ($tree) => $tree >= $curTree))){
                $numVisible++;
                $isVisible = true;
            }

            $dirScore = 0;
            foreach ($direction as $tree) {
                $dirScore++;
                if ($tree >= $curTree) break;
            }
            $scenicScore *= $dirScore;
        }

        $topScenicScore = max($scenicScore,$topScenicScore);
    }
}

printf("Visible trees: %d\n", $numVisible);
printf("Highest scenic score: %d\n", $topScenicScore);