<?php

/**
 * @link https://adventofcode.com/2022/day/4
 */

$inputs = file('input/day04.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$count1 = $count2 = 0;

foreach ($inputs as $line)
{
    [$p1, $p2] = explode(',', $line); 
    [$p1l, $p1h] = explode('-', $p1);
    [$p2l, $p2h] = explode('-', $p2);
    $s1 = range($p1l, $p1h);
    $s2 = range($p2l, $p2h);
    $count1 += (!array_diff($s1, $s2) || !array_diff($s2, $s1));
    $count2 += (count(array_merge($s1, $s2)) !== count(array_unique(array_merge($s1, $s2))));
}

echo $count1 . \PHP_EOL; // Part 1
echo $count2 . \PHP_EOL; // Part 2
