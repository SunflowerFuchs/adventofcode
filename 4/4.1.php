<?php

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$draws = array_map(fn (string $number) => (int)$number, explode(',',array_shift($inputs)));

// Split the rest of the file into two-dimensional arrays each of five rows & five columns, and turn every number into an array of [number => strings, drawn => bool]
$boards = array_map(
    fn(array $board) => array_map(
        fn(string $line) => array_map(
            fn(string $number) => ['num' => (int)$number, 'drawn' => false],
            explode(' ', preg_replace('/\s{2,}/', ' ', trim($line)))
        ), $board
    ), array_chunk($inputs, 5)
);

$winner = null;
$currentDraw = null;
$totalDrawnRows = $totalDrawnColumns = array_fill_keys(range(0, count($boards)), array_fill_keys(range(0, 4), []));
for($i = 0; $i < count($draws); $i++) {
    $currentDraw = $draws[$i];

    foreach ($boards as $boardId => &$board) {
        $drawnRows = &$totalDrawnRows[$boardId];
        $drawnColumns = &$totalDrawnColumns[$boardId];
        foreach ($board as $rowId => $row) {
            foreach ($row as $colId => $number) {
                if ($number['num'] === $currentDraw) {
                    $board[$rowId][$colId]['drawn'] = true;
                    $drawnRows[$rowId][$colId][] = $number;
                    $drawnColumns[$colId][$rowId][] = $number;
                }
            }
        }

        $hasWinnerColumn = !empty(array_filter($drawnColumns, fn($column) => count($column) === 5));
        $hasWinnerRow = !empty(array_filter($drawnRows, fn($row) => count($row) === 5));
        if($hasWinnerColumn || $hasWinnerRow) {
            $winner = $board;
            break 2;
        }
    }
}

if (!$winner) {
    die('No winner');
}

$sum = 0;
foreach ($winner as $row) {
    foreach ($row as $number) {
        echo $number['num'] . ($number['drawn'] ? 'X' : '') . ' ';
        if (!$number['drawn']) $sum += $number['num'];
    }
    echo PHP_EOL;
}

echo PHP_EOL;
echo 'Score: ' . ($sum * $currentDraw) . PHP_EOL;