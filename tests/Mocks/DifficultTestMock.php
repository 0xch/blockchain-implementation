<?php

namespace Tests\Mocks;

use Blockchain\Difficult;

class DifficultTestMock extends Difficult
{
    public function getForIndex(int $index): int
    {
        return 1;
    }
}