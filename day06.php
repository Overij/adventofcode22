<?php

/**
 * @link https://adventofcode.com/2022/day/6
 */

$inputs = str_split(file('input/day06.txt', FILE_IGNORE_NEW_LINES)[0]);

function findMarker($inputs, $count)
{
    $pos = $count - 1;
    $buffer = array_splice($inputs, 0, $pos);

    foreach ($inputs as $char)
    {
        ++$pos;
        $buffer[] = $char;
        if (count(array_unique($buffer)) == $count)
        {
            return $pos;
        }
        array_shift($buffer);
    }
}

echo findMarker($inputs, 4) . \PHP_EOL; // Part 1
echo findMarker($inputs, 14) . \PHP_EOL; // Part 2
