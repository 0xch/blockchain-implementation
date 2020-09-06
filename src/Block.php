<?php

namespace Blockchain;

class Block
{
    const ALGORITHM = 'sha256';
    const VALUE_TO_COMPARE_BLOCK = '0000000000000000000000000000000000000000000000000000000000000000'; //64x for sha256

    protected $index = 0;
    protected $nonce = 0;
    protected $previousHash;
    protected $timestamp;
    protected $hash;

    public function __construct()
    {
        $timestamp = time();
        $this->timestamp = $timestamp;
        $this->hash = $this->calculateHash();
    }

    protected function calculateHash()
    {
        $blockContent = $this->index . $this->nonce . $this->previousHash . $this->timestamp;

        return hash(self::ALGORITHM, $blockContent);
    }

    public function mineBlock(int $difficult)
    {
        $hash = $this->hash;
        $hash = $this->miningAlgorithm($hash, $difficult);
        $this->hash = $hash;
    }

    private function miningAlgorithm(string $hash, int $difficult): string
    {
        while ($this->hashPart($hash, $difficult) !== $this->hashPart(self::VALUE_TO_COMPARE_BLOCK, $difficult)) {
            $this->nonce++;
            $hash = $this->calculateHash();
        }

        return $hash;
    }

    private function hashPart(string $hash, int $difficult): string
    {
        return substr($hash, 0, $difficult);
    }

    public function setPreviousHash(string $previousHash): void
    {
        $this->previousHash = $previousHash;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): void
    {
        $this->index = $index;
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }
}