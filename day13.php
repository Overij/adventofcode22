<?php

/**
 * @link https://adventofcode.com/2022/day/13
 */

$inputs = file('input/day13.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function part1(array $inputs) : int
{
    $rightOrder = [];
    for ($i = 0; $i < count($inputs); $i += 2)
    {
        [$packet1, $packet2] = array_slice($inputs, $i, 2);
        $packet1 = eval('return ' . $packet1 . ';');
        $packet2 = eval('return ' . $packet2 . ';');

        if (compare($packet1, $packet2) === -1)
        {
            $rightOrder[] = ($i / 2) + 1;
        }
    }

    return array_sum($rightOrder);
}

function part2(array $inputs) : int
{
    $packets = [[[2]], [[6]]];
    foreach ($inputs as $packet)
    {
        $packets[] = eval('return ' . $packet . ';');
    }

    usort($packets, compare(...));

    $dividers = [];
    foreach ($packets as $key => $packet)
    {
        if ($packet === [[2]] || $packet === [[6]])
        {
            $dividers[] = $key + 1;
        }
    }

    return array_product($dividers);
}

function compare(array|int $left, array|int $right) : int
{
    if (!is_array($left) && !is_array($right))
    {
        return $left <=> $right;
    }

    if (is_array($left) && is_array($right))
    {
        if (count($left) == 0)
        {
            return -1;
        }

        for ($i = 0; $i < count($left); ++$i)
        {
            if (!array_key_exists($i, $right))
            {
                return 1;
            }

            if (($result = compare($left[$i], $right[$i])) !== 0)
            {
                return $result;
            }
        }

        return count($left) <=> count($right);
    }

    if (!is_array($left))
    {
        return compare([$left], $right);
    }
    return compare($left, [$right]);
}

echo part1($inputs) . \PHP_EOL; // Part 1
echo part2($inputs) . \PHP_EOL; // Part 2
