<?php

/**
 * @link https://adventofcode.com/2022/day/14
 */

$inputs = file('input/day14.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$caveMap = [];

function parseInput(array &$inputs, array &$caveMap) : void
{
    foreach ($inputs as $line)
    {
        $previous = null;
        foreach (explode(' -> ', $line) as $pair)
        {
            $current = explode(',', $pair);
            if ($previous !== null)
            {
                drawLine($caveMap, $current, $previous);
            }
            $previous = $current;
        }
    }
    fillAir($caveMap);
    $caveMap[0][500] = '+';
}

function drawLine(array &$map, array $from, array $to) : void
{
    if ($from[0] === $to[0])
    {
        $x = $from[0];
        foreach(range($from[1], $to[1]) as $y)
        {
            $map[$y][$x] = '#';
        }
    }
    elseif ($from[1] === $to[1])
    {
        $y = $from[1];
        foreach(range($from[0], $to[0]) as $x)
        {
            $map[$y][$x] = '#';
        }
    }
}

function fillAir(array &$map) : void
{
    $map = $map + array_fill_keys(range(0, max(array_keys($map))), []);
    ksort($map);
    $minX = $maxX = null;
    foreach ($map as $row)
    {
        if (count($row) == 0)
        {
            continue;
        }
        $keys = array_keys($row);
        if ($minX === null || $minX > min($keys))
        {
            $minX = min($keys);
        }
        if ($maxX === null || $maxX < max($keys))
        {
            $maxX = max($keys);
        }
    }
    for($i = 0; $i < count($map); ++$i)
    {
        $map[$i] = $map[$i] + array_fill_keys(range($minX, $maxX), '.');
        ksort($map[$i]);
    }
}

function part1(array $map) : int
{
    for ($sand_x = 500, $sand_y = 0; ; $sand_x = 500, $sand_y = 0)
    {
        for (;;)
        {
            if (!array_key_exists($sand_y + 1, $map))
            {
                break 2;
            }
            if ($map[$sand_y + 1][$sand_x] === '.')
            {
                ++$sand_y;
                continue;
            }
            else
            {
                // Try left
                if (!array_key_exists($sand_x - 1, $map[$sand_y + 1]))
                {
                    break 2;
                }
                if ($map[$sand_y + 1][$sand_x - 1] === '.')
                {
                    ++$sand_y;
                    --$sand_x;
                    continue;
                }

                // Try right
                if (!array_key_exists($sand_x + 1, $map[$sand_y + 1]))
                {
                    break 2;
                }
                if ($map[$sand_y + 1][$sand_x + 1] === '.')
                {
                    ++$sand_y;
                    ++$sand_x;
                    continue;
                }

                // Rest
                $map[$sand_y][$sand_x] = 'o';
                break;
            }
        }
    }

    // Visualization
    //drawMap($map);

    // Count sand
    return array_sum(array_map(fn ($x) => count(array_filter($x, fn ($y) => $y === 'o')), $map));
}

function part2(array $map)
{
    for ($sand_x = 500, $sand_y = 0; ; $sand_x = 500, $sand_y = 0)
    {
        for (;;)
        {
            if ($map[$sand_y + 1][$sand_x] === '.')
            {
                ++$sand_y;
                continue;
            }
            else
            {
                // Try left
                if (!array_key_exists($sand_x - 1, $map[$sand_y + 1]))
                {
                    widenMap($map, $sand_x - 1);
                }
                if ($map[$sand_y + 1][$sand_x - 1] === '.')
                {
                    ++$sand_y;
                    --$sand_x;
                    continue;
                }

                // Try right
                if (!array_key_exists($sand_x + 1, $map[$sand_y + 1]))
                {
                    widenMap($map, $sand_x + 1);
                }
                if ($map[$sand_y + 1][$sand_x + 1] === '.')
                {
                    ++$sand_y;
                    ++$sand_x;
                    continue;
                }

                // Rest
                $map[$sand_y][$sand_x] = 'o';

                if ($sand_x === 500 && $sand_y === 0)
                {
                    break 2;
                }

                break;
            }
        }
    }

    // Visualization
    //drawMap($map);

    // Count sand
    return array_sum(array_map(fn ($x) => count(array_filter($x, fn ($y) => $y === 'o')), $map));
}

function widenMap(array &$map, int $col) : void
{
    $i = 0;
    for (; $i < count($map); ++$i)
    {
        $map[$i][$col] = '.';
        ksort($map[$i]);
    }
    $map[$i - 1][$col] = '#';
}

function drawMap(array &$caveMap) : void
{
    foreach ($caveMap as $row)
    {
        echo join('', $row) . \PHP_EOL;
    }
}

parseInput($inputs, $caveMap);

echo part1($caveMap) . \PHP_EOL;

$caveMap[] = array_fill(min(array_keys($caveMap[0])), count($caveMap[0]), '.');
$caveMap[] = array_fill(min(array_keys($caveMap[0])), count($caveMap[0]), '#');
echo part2($caveMap) . \PHP_EOL;
