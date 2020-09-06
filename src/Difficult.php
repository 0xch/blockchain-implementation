<?php

namespace Blockchain;

class Difficult
{
    public function getForIndex(int $index): int
    {
        return (int)ceil($index / 10);
    }
}