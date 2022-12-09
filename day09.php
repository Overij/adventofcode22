<?php

/**
 * @link https://adventofcode.com/2022/day/9
 */

$inputs = file('input/day09.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Head at index 0
// Part 1 - Tail at index 1
// Part 2 - Tail at index 9
$knots = array_fill(0, 10, [0, 0]);

// Array of visited x, y coords
$visited1 = $visited2 = [];// [[0, 0]];

foreach ($inputs as $line)
{
    [$direction, $steps] = explode(' ', $line);

    for ($i = 0; $i < $steps; ++$i)
    {
        switch ($direction)
        {
            case 'R':
                $knots[0][0]++;
                break;
            case 'L':
                $knots[0][0]--;
                break;
            case 'U':
                $knots[0][1]++;
                break;
            case 'D':
                $knots[0][1]--;
                break;
        }

        $prev = $knots[0];
        for ($j = 1; $j < count($knots); ++$j)
        {
            if (in_array($prev, adjacent($knots[$j])))
            {
                break;
            }

            $knots[$j][0] += min(max($prev[0] - $knots[$j][0], -1), 1);
            $knots[$j][1] += min(max($prev[1] - $knots[$j][1], -1), 1);
            $prev = $knots[$j];
        }

        $visited1[] = $knots[1];
        $visited2[] = $knots[array_key_last($knots)];
    }
}

function adjacent(array $pos) : array
{
    $adjacent = [];
    for ($i = $pos[0] - 1; $i < $pos[0] + 2; ++$i)
    {
        for ($j = $pos[1] - 1; $j < $pos[1] + 2; ++$j)
        {
            $adjacent[] = [$i, $j];
        }
    }
    return $adjacent;
}

echo count(array_unique($visited1, \SORT_REGULAR)) . \PHP_EOL; // Part 1
echo count(array_unique($visited2, \SORT_REGULAR)) . \PHP_EOL; // Part 2
