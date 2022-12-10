<?php

/**
 * @link https://adventofcode.com/2022/day/10
 */

$inputs = file('input/day10.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Cycle counter and register X
$cycle = 0;
$x = 1;

// Part 1
$signals = [];
$checkpoints = [20, 60, 100, 140, 180, 220];

// Part 2
$screen = array_fill(0, 6, array_fill(0, 40, '.'));
$row = 0;

foreach ($inputs as $line)
{
    if ($line === 'noop')
    {
        $cycles = 1;
        $val = 0;
    }
    else
    {
        $cycles = 2;
        [, $val] = explode(' ', $line);
    }

    for ($i = 0; $i < $cycles; ++$i)
    {
        ++$cycle;

        // Part 1
        if (in_array($cycle, $checkpoints))
        {
            $signals[] = $cycle * $x;
        }

        // Part 2
        if ($cycle % 40 == 0)
        {
            ++$row;
        }

        if (in_array(($cycle - 1) % 40, [$x - 1, $x, $x + 1]))
        {
            $screen[$row][($cycle - 1) % 40] = '#';
        }
    }

    $x += (int) $val;
}

// Part 1
echo array_sum($signals) . \PHP_EOL;

// Part 2
foreach ($screen as $r)
{
    echo join ('', $r) . \PHP_EOL;
}
