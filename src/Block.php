<?php

namespace Blockchain;

class Block
{
    protected $version = 1;
    protected $index = 0;
    protected $nonce = 0;
    protected $previousHash;
    protected $timestamp;
    protected $hash;

    public function __construct()
    {
        $timestamp = time();
        $this->timestamp = $timestamp;
    }

    public static function createFromFields(array $fields): Block
    {
        $block = new Block();
        $block->setVersion($fields[0]);
        $block->setIndex($fields[1]);
        $block->setNonce($fields[2]);
        $block->setPreviousHash($fields[3]);
        $block->setTimestamp($fields[4]);
        $block->setHash($fields[5]);

        return $block;
    }

    public function toFields(): array
    {
        return [
            $this->version,
            $this->index,
            $this->nonce,
            $this->previousHash,
            $this->timestamp,
            $this->hash
        ];
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): void
    {
        $this->index = $index;
    }

    public function getNonce(): int
    {
        return $this->nonce;
    }

    public function setNonce(int $nonce): void
    {
        $this->nonce = $nonce;
    }

    public function getPreviousHash(): string
    {
        return $this->previousHash;
    }

    public function setPreviousHash($previousHash): void
    {
        $this->previousHash = $previousHash;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }
}