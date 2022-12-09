<?php

/**
 * @link https://adventofcode.com/2022/day/7
 */

$inputs = file('input/day07.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

enum NodeType : string
{
    case DIR = 'dir';
    case FILE = 'file';
}

class Node
{
    /** @var \Node[] **/
    public array $children = [];

    public function __construct(
        public ?Node $parent,
        public NodeType $type,
        public string $name,
        public int $size = 0
    ) {}

    public function getFullPath() : string
    {
        $path = $this->name;
        $parent = $this->parent;
        while ($parent !== null)
        {
            $path = $parent->name . '/' . $path;
            $parent = $parent->parent;
        }
        return strlen($path) == 1 ? $path : substr($path, 1);
    }
}

// Our filesystem root node
$fs = new Node(null, NodeType::DIR, '/');

// Pointer to current directory
$cd = $fs;

foreach ($inputs as $line)
{
    $parts = explode(' ', $line);
    
    // Input
    if ($parts[0] === '$')
    {
        switch ($parts[1])
        {
            case 'cd':
                switch ($parts[2])
                {
                    case '..':
                        $cd = $cd->parent ?: $cd;
                        break;
                    case '/':
                        $cd = $fs;
                        break;
                    default:
                        $cd = $cd->children[$parts[2]];
                        break;
                }
                break;
            case 'ls':
                // ls can be ignored
                break;
            default:
                break;
        }
        continue;
    }

    // Output
    if (!array_key_exists($parts[1], $cd->children))
    {
        $name = $parts[1];
        $size = is_numeric($parts[0]) ? (int) $parts[0] : 0;
        $type = is_numeric($parts[0]) ? NodeType::FILE : NodeType::DIR;
        $cd->children[$name] = new Node($cd, $type, $name, $size);
    }
}

function dirSize(\Node $node, array &$sizeTable)
{
    $size = $node->size;
    foreach ($node->children as $child)
    {
        $size += dirSize($child, $sizeTable);
    }
    if ($node->type === NodeType::DIR)
    {
        $sizeTable[$node->getFullPath()] = $size;
    }
    return $size;
}

// Calculate size for each directory
$sizeTable = [];
dirSize($fs, $sizeTable);

// Part 1
$sum = array_reduce($sizeTable, function ($carry, $item) { return ($item <= 100000) ? $carry + $item : $carry; }, 0);
echo $sum . \PHP_EOL;

// Part 2
$freeSpace = 70000000 - $sizeTable['/'];
$neededSpace = 30000000 - $freeSpace;
$suitableDirs = array_filter($sizeTable, fn ($x) => $x >= $neededSpace);
echo min($suitableDirs) . \PHP_EOL;

// Extra: for filesystem visualization
function printFs($node, $level = 0)
{
    echo str_repeat("\t", $level) . '- ' . $node->name . ' (' .
        (($node->type === NodeType::FILE) ? 
            'file, size=' . $node->size : 
            'dir, children=' . count($node->children)) .
        ')' . \PHP_EOL;
    foreach ($node->children as $n)
    {
        printFs($n, $level + 1);
    }
}
