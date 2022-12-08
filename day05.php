<?php

/**
 * @link https://adventofcode.com/2022/day/5
 */

$inputs = file('input/day05.txt', FILE_IGNORE_NEW_LINES);

$stacks = [];

// Parse stacks
while (strlen($line = array_shift($inputs)) !== 0)
{
    $split = str_split($line);
    $index = 1;
    if ($split[0] === '[')
    {
        for ($i = 1; $i < count($split); $i += 4)
        {
            if (!array_key_exists($index, $stacks))
            {
                $stacks[$index] = [];
            }
            if ($split[$i] !== ' ')
            {
                $stacks[$index][] = $split[$i];
            }
            ++$index;
        }
    }
}

// Reverse each stack so indexing starts from bottom
$stacks1 = $stacks2 = array_map(fn ($x) => array_reverse($x), $stacks);

// Process moves
foreach ($inputs as $line)
{
    preg_match("/move (\d+) from (\d+) to (\d+)/", $line, $matches);

    // Part 1
    for ($i = 0; $i < $matches[1]; ++$i)
    {
        $stacks1[$matches[3]][] = array_pop($stacks1[$matches[2]]);
    }
    
    // Part 2
    $stacks2[$matches[3]] = array_merge($stacks2[$matches[3]], array_splice($stacks2[$matches[2]], -$matches[1]));
}

// Take the top one from each
echo array_reduce($stacks1, fn ($carry, $item)  => $carry . array_pop($item), '') . \PHP_EOL; // Part 1
echo array_reduce($stacks2, fn ($carry, $item)  => $carry . array_pop($item), '') . \PHP_EOL; // Part 2
