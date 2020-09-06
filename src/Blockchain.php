<?php

namespace Blockchain;

use Tightenco\Collect\Support\Collection;

class Blockchain
{
    /** @var Block[] */
    protected $chain = [];

    public function __construct()
    {
        $genesisBlock = new Block(0, 0);
        $this->addBlock($genesisBlock);
    }

    public function addBlock(Block $block)
    {
        $this->chain[] = $block;
    }

    public function blocksAmount(): int
    {
        return count($this->chain);
    }

    public function getLastBlock(): Block
    {
        return Collection::make($this->chain)->last();
    }
}