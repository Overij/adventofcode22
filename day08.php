<?php

/**
 * @link https://adventofcode.com/2022/day/8
 */

$inputs = file('input/day08.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$grid = [];

foreach ($inputs as $line)
{
    $row = [];
    foreach (str_split($line) as $c)
    {
        $row[] = (int) $c;
    }
    $grid[] = $row;
}

// Part 1 - Start with edge tree count
$visible = (count($grid[0]) - 1) * 2 + (count(array_column($grid, 0)) - 1) * 2;

// Part 2
$highScore = 0;

// Loop through each tree, ignoring those on edge
for ($i = 1; $i < count($grid) - 1; ++$i)
{
    for ($j = 1; $j < count($grid[$i]) - 1; ++$j)
    {
        $left = array_slice($grid[$i], 0, $j);
        $right = array_slice($grid[$i], $j + 1);
        $up = array_slice(array_column($grid, $j), 0, $i);
        $down = array_slice(array_column($grid, $j), $i + 1);

        // Part 1
        $visible += (
            (max($left) < $grid[$i][$j]) ||
            (max($right) < $grid[$i][$j]) ||
            (max($up) < $grid[$i][$j]) ||
            (max($down) < $grid[$i][$j])
        );

        // Part 2
        $left = array_reverse($left);
        $up = array_reverse($up);

        $score = 
            viewDistance($left, $grid[$i][$j]) *
            viewDistance($right, $grid[$i][$j]) *
            viewDistance($up, $grid[$i][$j]) *
            viewDistance($down, $grid[$i][$j])
        ;
        
        if ($score > $highScore)
        {
            $highScore = $score;
        }
        
    }
}

function viewDistance(array $array, int $max) : int
{
    $dist = 0;
    for ($i = 0; $i < count($array); ++$i)
    {
        ++$dist;
        if ($array[$i] >= $max)
        {
            break;
        }
    }
    return $dist;
}

echo $visible . \PHP_EOL; // Part 1
echo $highScore . \PHP_EOL; // Part 2
