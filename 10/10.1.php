<?php

const SCORE_MAPPING = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

const CLOSING_MAPPING = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];

$inputs = array_filter(explode("\n", file_get_contents('input.txt')));

$score = 0;
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
                    $score += SCORE_MAPPING[$char];
                    continue 3;
                }
                break;
        }
    }
}

echo $score . PHP_EOL;