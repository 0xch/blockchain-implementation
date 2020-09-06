<?php

namespace Blockchain;

use DateTime;

class Block
{
    const ALGORITHM = 'sha256';

    protected $nonce;
    protected $previousHash;
    protected $timestamp;
    protected $hash;

    public function __construct(int $nonce, string $previousHash)
    {
        $this->nonce = $nonce;
        $this->previousHash = $previousHash;
        $this->timestamp = (new DateTime())->format(DateTime::ISO8601);

        $this->hash = $this->calculateHash();
    }

    public function calculateHash()
    {
        $blockContent = $this->nonce . $this->previousHash . $this->timestamp;
        return hash(self::ALGORITHM, $blockContent);
    }

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

}