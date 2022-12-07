<?php

/**
 * @link https://adventofcode.com/2022/day/2
 */

$inputs = file('input/day02.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$score1 = $score2 = 0;

foreach ($inputs as $line)
{
    switch ($line)
    {
        case 'A X': // Rock - Rock/Lose
            $score1 += (1 + 3);
            $score2 += (3 + 0);
            break;
        case 'A Y': // Rock - Paper/Draw
            $score1 += (2 + 6);
            $score2 += (1 + 3);
            break;
        case 'A Z': // Rock - Scissors/Win
            $score1 += (3 + 0);
            $score2 += (2 + 6);
            break;
        case 'B X': // Paper - Rock/Lose
            $score1 += (1 + 0);
            $score2 += (1 + 0);
            break;
        case 'B Y': // Paper - Paper/Draw
            $score1 += (2 + 3);
            $score2 += (2 + 3);
            break;
        case 'B Z': // Paper - Scissors/Win
            $score1 += (3 + 6);
            $score2 += (3 + 6);
            break;
        case 'C X': // Scissors - Rock/Lose
            $score1 += (1 + 6);
            $score2 += (2 + 0);
            break;
        case 'C Y': // Scissors - Paper/Draw
            $score1 += (2 + 0);
            $score2 += (3 + 3);
            break;
        case 'C Z': // Scissors - Scissors/Win
            $score1 += (3 + 3);
            $score2 += (1 + 6);
            break;
    }
}

echo $score1 . \PHP_EOL;
echo $score2 . \PHP_EOL;
