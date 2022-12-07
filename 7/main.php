<?php

const DIR_FILTER_LIMIT = 100000;
const FS_SIZE = 70000000;
const UPDATE_SIZE = 30000000;

class File {
    protected int $size = 0;
    protected string $name;

    public function __construct(string $name, int $size){
        $this->name = $name;
        $this->size = $size;
    }

    public function getName(): int
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
class Dir extends File {
    /** @var File[] $files */
    public array $files = [];

    public function __construct(string $name){
        parent::__construct($name, -1);
    }

    public function addFile(File $file) :void
    {
        $this->size = -1;
        $this->files[$file->name] = $file;
    }

    public function getSize() : int {
        if ($this->size === -1) {
            $size = 0;
            foreach ($this->files as $file) {
                $size += $file->getSize();
            }
            $this->size = $size;
        }
        return $this->size;
    }
}

$input = explode("\n", trim(file_get_contents(__DIR__ . '/input.txt')));

$rootDir = new Dir('/');
$curPath = [$rootDir];
$curDir = $rootDir;
$dirs = [$rootDir];
foreach ($input as $line) {
    switch (true) {
        case $line === '$ cd /':
            // skip root dir
            continue 2;
        case str_starts_with($line, '$'):
            $command = substr($line, 2, 2);
            if ($command !== 'cd') continue 2;

            $path = substr($line, 5);
            if ($path === '..') {
                array_pop($curPath);
                $curDir = $curPath[array_key_last($curPath)] ?? null;
                continue 2;
            }

            $dir = $curDir->files[$path];
            if ($curDir === null) {
                $rootDir = $dir;
            }
            $curDir->addFile($dir);
            $curDir = $dir;
            $curPath[] = $dir;
            break;
        default:
            [$size, $name] = explode(' ', $line);
            if ($size === 'dir') {
                $dir = new Dir($name);
                $curDir->addFile($dir);
                $dirs[] = $dir;
                continue 2;
            }

            $file = new File($name, $size);
            $curDir->addFile($file);
    }
}

// Calculat the sum of all dirs under X
$smallDirs = array_filter($dirs, fn (Dir $dir) => $dir->getSize() < DIR_FILTER_LIMIT);
$smallDirSum = array_sum(array_map(fn (Dir $dir) => $dir->getSize(), $smallDirs));
printf("Sum of small dirs: %d\n", $smallDirSum);

// Calculate the best file to delete to reach the required free space
$usedSpace = $rootDir->getSize();
$freeSpace = FS_SIZE - $usedSpace;
$neededSpace = UPDATE_SIZE - $freeSpace;
$largeDirs = array_filter($dirs, fn (Dir $dir) => $dir->getSize() >= $neededSpace);
usort($largeDirs, fn (Dir $a, Dir $b) => $a->getSize() <=> $b->getSize());
printf("Size of best candidate to delete: %d\n", $largeDirs[0]->getSize());
