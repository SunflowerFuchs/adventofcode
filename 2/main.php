<?php

enum RPS: int
{
    case ROCK = 1;
    case PAPER = 2;
    case SCISSORS = 3;
}

enum WINNER: int
{
    case OPPONENT = 0;
    case DRAW = 3;
    case ME = 6;
}

function mapMoves(string $opponent, string $response): array {
    return [
        match ($opponent) {
            'A' => RPS::ROCK,
            'B' => RPS::PAPER,
            'C' => RPS::SCISSORS,
        },
        match ($response) {
            'X' => RPS::ROCK,
            'Y' => RPS::PAPER,
            'Z' => RPS::SCISSORS,
        }
    ];
}

function findWinner(RPS $opponent, RPS $response): WINNER {
    return match (true) {
        $opponent === RPS::ROCK && $response === RPS::ROCK
        , $opponent === RPS::PAPER && $response === RPS::PAPER
        , $opponent === RPS::SCISSORS && $response === RPS::SCISSORS => WINNER::DRAW,
        $opponent === RPS::ROCK && $response === RPS::PAPER
        , $opponent === RPS::PAPER && $response === RPS::SCISSORS
        , $opponent === RPS::SCISSORS && $response === RPS::ROCK => WINNER::ME,
        default => WINNER::OPPONENT
    };
}

$lines = array_filter(explode("\n", file_get_contents(__DIR__ . '/input.txt')));

$totalScore = 0;
foreach ($lines as $line) {
    [$opponent, $response] = mapMoves(...explode(' ', $line));
    $winner = findWinner($opponent, $response);
    $score = $response->value + $winner->value;
    $totalScore += $score;
}

printf("Total score: %d\n", $totalScore);