<?php

const NUM_ROUNDS = 10000;

class Item
{
    public function __construct(
        /** @var int[] $worry */
        public array $worry
    )
    {
    }

    /** @param Monkey[] $monkeys */
    public function update(string $increment, string $operation, array $monkeys): void
    {
        foreach ($this->worry as $id => $worry) {
            $monkey = $monkeys[$id];
            $divisor = $monkey->condition;
            $right = $increment === 'old' ? $worry : $increment;
            $this->worry[$monkey->id] = match ($operation) {
                '+' => (($worry % $divisor) + ($right % $divisor)) % $divisor,
                '*' => (($worry % $divisor) * ($right % $divisor)) % $divisor,
            };
        }
    }

    public function __toString(): string
    {
        return sprintf('(%s)', implode(', ', $this->worry));
    }
}

class Monkey
{
    public int $inspections = 0;

    public function __construct(
        public int    $id,
        /** @var Item[] $items */
        public array  $items,
        public string $operation,
        public string $increment,
        public int    $condition,
        protected int $trueTarget,
        protected int $falseTarget
    )
    {
    }

    public function catch(Item $item): void
    {
        $this->items[] = $item;
    }

    /** @param Monkey[] $monkeys */
    public function doRound(array $monkeys): void
    {
        while (!empty($this->items)) {
            $this->inspections++;
            $item = array_shift($this->items);
            $item->update($this->increment, $this->operation, $monkeys);
            $targetId = $item->worry[$this->id] % $this->condition === 0 ? $this->trueTarget : $this->falseTarget;
            $monkeys[$targetId]->catch($item);
        }
    }
}

$content = trim(file_get_contents(__DIR__ . '/input.txt'));
$inputs = array_map(fn($lines) => explode("\n", $lines), explode("\n\n", $content));

/** @var Monkey[] $monkeys */
$monkeys = [];
$allItems = [];
foreach ($inputs as $monkeyData) {
    $id = intval(substr($monkeyData[0], 7, -1));
    $allItems[$id] = array_map(fn($item) => intval($item), explode(', ', substr($monkeyData[1], 18)));
    [$action, $increment] = explode(' ', substr($monkeyData[2], 23));
    $condition = intval(substr($monkeyData[3], 21));
    $trueTarget = intval(substr($monkeyData[4], 29));
    $falseTarget = intval(substr($monkeyData[5], 30));

    $monkeys[$id] = new Monkey($id, [], $action, $increment, $condition, $trueTarget, $falseTarget);
}

foreach ($allItems as $id => $items) {
    foreach ($items as $item) {
        $worry = [];
        foreach ($monkeys as $iId => $monkey) {
            $worry[$iId] = $item % $monkey->condition;
        }
        $monkeys[$id]->catch(new Item($worry));
    }
}

for ($i = 1; $i <= NUM_ROUNDS; $i++) {
    foreach ($monkeys as $id => $monkey) {
        $monkey->doRound($monkeys);
    }
}

print("Num inspections: \n");
foreach ($monkeys as $id => $monkey) {
    printf("Monkey %d: %s\n", $id, $monkey->inspections);
}
print("\n");

usort($monkeys, fn($monkeyA, $monkeyB) => $monkeyB->inspections <=> $monkeyA->inspections);
printf("Monkey business: %d\n", $monkeys[0]->inspections * $monkeys[1]->inspections);