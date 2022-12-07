<?php

/**
 * @link https://adventofcode.com/2022/day/1
 */

$inputs = file('input/day01.txt', FILE_IGNORE_NEW_LINES);

$sums = [0];
$counter = 0;

foreach ($inputs as $line)
{
    if (strlen($line) == 0)
    {
        $sums[++$counter] = 0;
        continue;
    }
    $sums[$counter] += (int) $line;
}

rsort($sums);
echo $sums[0] . \PHP_EOL; // Part 1
echo $sums[0] + $sums[1] + $sums[2] . \PHP_EOL; // Part 2
