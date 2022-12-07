<?php

/**
 * @link https://adventofcode.com/2022/day/3
 */

$inputs = file('input/day03.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$prios = array_flip(array_merge(range('a', 'z'), range('A', 'Z')));
$sum = 0;

foreach ($inputs as $line)
{
    $comp1 = str_split(substr($line, 0, strlen($line) / 2));
    $comp2 = str_split(substr($line, strlen($line) / 2));
    $common = array_intersect($comp1, $comp2);
    $sum += $prios[array_values($common)[0]] + 1;
}

echo $sum . \PHP_EOL; // Part 1

$sum = 0;

for ($i = 0; $i < count($inputs); $i += 3)
{
    $common = array_intersect(str_split($inputs[$i]), str_split($inputs[$i + 1]), str_split($inputs[$i + 2]));
    $sum += $prios[array_values($common)[0]] + 1;
}

echo $sum . \PHP_EOL; // Part 2
