<?php

namespace Blockchain;

class BlockMining
{
    const ALGORITHM = 'sha256';
    const VALUE_TO_COMPARE_BLOCK = '0000000000000000000000000000000000000000000000000000000000000000'; //64x for sha256

    protected $difficult;

    public function __construct(Difficult $difficult)
    {
        $this->difficult = $difficult;
    }

    public function mineBlock(Block $block)
    {
        $hash = $this->calculateHash($block);
        $difficult = $this->difficult->getForIndex($block->getIndex());
        while ($this->hashPart($hash, $difficult) !== $this->hashPart(self::VALUE_TO_COMPARE_BLOCK, $difficult)) {
            $nonce = $block->getNonce() + 1;
            $block->setNonce($nonce);
            $hash = $this->calculateHash($block);
        }

        $block->setHash($hash);
    }

    public function calculateHash(Block $block)
    {
        $blockContent = $block->getIndex() . $block->getNonce() . $block->getPreviousHash() . $block->getTimestamp();

        return hash(self::ALGORITHM, $blockContent);
    }

    private function hashPart(string $hash, int $difficult): string
    {
        return substr($hash, 0, $difficult);
    }

    public function actualDifficult(): int
    {
        return $this->difficult;
    }
}