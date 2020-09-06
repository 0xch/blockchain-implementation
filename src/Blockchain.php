<?php

namespace Blockchain;

use Tightenco\Collect\Support\Collection;

class Blockchain
{
    const GENESIS_BLOCKS_AMOUNT = 1;

    /** @var Block[] */
    protected $chain = [];
    protected $blockMining;

    public function __construct(BlockMining $blockMining, array $chain = [])
    {
        $this->blockMining = $blockMining;
        $this->chain = $chain;

        if (!$chain) {
            $genesisBlock = $this->createGenesisBlock();
            $genesisBlock->setHash($blockMining->calculateHash($genesisBlock));
            $this->chain = [$genesisBlock];
        }
    }

    public function addBlock(Block $newBlock)
    {
        $previousBlock = $this->getLastBlock();
        $newBlock->setPreviousHash($previousBlock->getHash());
        $newBlock->setIndex($previousBlock->getIndex() + 1);
        $this->blockMining->mineBlock($newBlock);

        $this->chain[] = $newBlock;
    }

    public function blocksAmount(): int
    {
        return count($this->chain);
    }

    public function getLastBlock(): Block
    {
        return Collection::make($this->chain)->last();
    }

    public function getChain(): array
    {
        return $this->chain;
    }

    public function isChainValid(): bool
    {
        $previousHash = $this->chain[(self::GENESIS_BLOCKS_AMOUNT - 1)]->getHash();
        for ($i = self::GENESIS_BLOCKS_AMOUNT; $i < count($this->chain); $i++) {
            /** @var Block $block */
            $block = $this->chain[$i];
            if ($block->getPreviousHash() !== $previousHash) {
                return false;
            }

            $previousHash = $block->getHash();
        }

        return true;
    }

    private function createGenesisBlock(): Block
    {
        $genesisBlock = new Block();
        $genesisBlock->setPreviousHash(0);

        return $genesisBlock;
    }
}