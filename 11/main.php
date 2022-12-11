<?php

const NUM_ROUNDS = 20;

/** @var Monkey[] $monkeys */
$monkeys = [];

class Monkey
{
    public int $inspections = 0;

    public function __construct(public array $items, protected array $funcs)
    {
    }

    public function catch($item): void
    {
        $this->items[] = $item;
    }

    public function doRound(array $monkeys): void
    {
        foreach ($this->items as $id => $item) {
            $this->inspections++;
            $worry = floor($this->funcs[0]($item) / 3);
            $targetId = $this->funcs[1]($worry);
            unset($this->items[$id]);
            $monkeys[$targetId]->catch($worry);
        }
    }
}

$content = trim(file_get_contents(__DIR__ . '/input.txt'));
$inputs = array_map(fn($lines) => explode("\n", $lines), explode("\n\n", $content));

foreach ($inputs as $monkeyData) {
    $num = intval(substr($monkeyData[0], 7, -1));
    $items = array_map(fn($item) => floatval($item), explode(', ', substr($monkeyData[1], 18)));
    $actionData = explode(' ', substr($monkeyData[2], 23));
    $action = match ($actionData[0]) {
        '+' => fn(float $input) => $input + ($actionData[1] === 'old' ? $input : $actionData[1]),
        '*' => fn(float $input) => $input * ($actionData[1] === 'old' ? $input : $actionData[1]),
        '-' => fn(float $input) => $input - ($actionData[1] === 'old' ? $input : $actionData[1]),
        '/' => fn(float $input) => $input / ($actionData[1] === 'old' ? $input : $actionData[1]),
    };

    $condition = intval(substr($monkeyData[3], 21));
    $trueTarget = intval(substr($monkeyData[4], 29));
    $falseTarget = intval(substr($monkeyData[5], 30));

    $findTarget = fn(float $input) => $input % $condition === 0 ? $trueTarget : $falseTarget;

    $monkeys[$num] = new Monkey($items, [$action, $findTarget]);
}

for ($i = 1; $i <= NUM_ROUNDS; $i++) {
    printf("Round %d:\n", $i);
    foreach ($monkeys as $id => $monkey) {
        $monkey->doRound($monkeys);
    }
    foreach ($monkeys as $id => $monkey) {
        printf("Monkey %d: %s\n", $id, implode(', ', $monkey->items));
    }
    print("\n");
}

print("Num inspections: \n");
foreach ($monkeys as $id => $monkey) {
    printf("Monkey %d: %s\n", $id, $monkey->inspections);
}
print("\n");

usort($monkeys, fn($monkeyA, $monkeyB) => $monkeyB->inspections <=> $monkeyA->inspections);
printf("Monkey business: %d\n", $monkeys[0]->inspections * $monkeys[1]->inspections);