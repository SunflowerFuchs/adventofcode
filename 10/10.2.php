<?php

const SCORE_MAPPING = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

const CLOSING_MAPPING = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$scores = [];
foreach ($inputs as $line) {
    $expected = [];
    foreach (str_split($line) as $char) {
        switch ($char) {
            case '(':
            case '[':
            case '{':
            case '<':
                array_unshift($expected, CLOSING_MAPPING[$char]);
                break;
            default:
                $expectedChar = array_shift($expected);
                if ($char !== $expectedChar) {
                    continue 3;
                }
                break;
        }
    }

    if (!empty($expected)) {
        $score = 0;
        while (!empty($expected)) {
            $score *= 5;
            $score += SCORE_MAPPING[array_shift($expected)];
        }
        $scores[] = $score;
    }
}

sort($scores);
$midpoint = floor(count($scores) / 2);
echo $scores[$midpoint]. PHP_EOL;