<?php

/**
 * @link https://adventofcode.com/2022/day/11
 */

$inputs = file('input/day11.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

class Monkey
{
    /** @var int[] $items */
    public array $items;
    public string $operation;
    public int $test;
    public int $ifTrue;
    public int $ifFalse;
    public int $inspectCount = 0;
}

$monkeys = [];
$id = 0;

foreach ($inputs as $line)
{
    if (preg_match('/Monkey (\d+):/', $line, $matches))
    {
        $monkeys[($id = (int) $matches[1])] = new Monkey();
    }
    elseif (preg_match('/Starting items: (.*)/', $line, $matches))
    {
        $monkeys[$id]->items = explode(', ', $matches[1]);
    }
    elseif (preg_match('/Operation: new = (.*)/', $line, $matches))
    {
        $monkeys[$id]->operation = $matches[1];
    }
    elseif (preg_match('/Test: divisible by (\d+)/', $line, $matches))
    {
        $monkeys[$id]->test = (int) $matches[1];
    }
    elseif (preg_match('/If true: throw to monkey (\d+)/', $line, $matches))
    {
        $monkeys[$id]->ifTrue = (int) $matches[1];
    }
    elseif (preg_match('/If false: throw to monkey (\d+)/', $line, $matches))
    {
        $monkeys[$id]->ifFalse = (int) $matches[1];
    }
}

function monkeyBusiness(array $monkeys, int $rounds, int $stressDivisor) : int
{
    // Get a common divisor by multiplying them all together
    $commonDivisor = array_reduce($monkeys, fn ($carry, Monkey $item) => $carry * $item->test, 1);

    while ($rounds-- > 0)
    {
        foreach ($monkeys as $monkey)
        {
            while (($item = array_shift($monkey->items)) !== null)
            {
                $monkey->inspectCount++;
                $item = (int) (eval('return ' . str_replace('old', $item, $monkey->operation) . ';') / $stressDivisor);
                $item %= $commonDivisor;
                $throwTo = ($item % $monkey->test == 0) ? $monkey->ifTrue : $monkey->ifFalse;
                $monkeys[$throwTo]->items[] = $item;
            }
        }
    }

    usort($monkeys, fn (Monkey $a, Monkey $b) => $b->inspectCount <=> $a->inspectCount);
    return array_reduce(array_slice($monkeys, 0, 2), fn ($carry, Monkey $item) => $carry * $item->inspectCount, 1);
}

echo monkeyBusiness(array_map(fn ($x) => clone $x, $monkeys), 20, 3) . \PHP_EOL; // Part 1
echo monkeyBusiness(array_map(fn ($x) => clone $x, $monkeys), 10000, 1) . \PHP_EOL; // Part 2
