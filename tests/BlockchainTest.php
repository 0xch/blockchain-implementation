<?php

namespace Tests;

use Blockchain\Block;
use Blockchain\Blockchain;
use PHPUnit\Framework\TestCase;

class BlockchainTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNewBlockchainContainsGenesisBlock()
    {
        //when
        $blockchain = new Blockchain();

        //then
        $lastBlock = $blockchain->getLastBlock();
        $this->assertIsObject($lastBlock);
        $this->assertEquals(1, $blockchain->blocksAmount());
    }

    /**
     * @test
     */
    public function shouldAddBlock()
    {
        //given
        $blockchain = new Blockchain();

        //when
        $block = new Block();
        $blockchain->addBlock($block);

        //then
        $this->assertEquals(2, $blockchain->blocksAmount());
    }

    /**
     * @test
     */
    public function shouldChainBeValid()
    {
        //given
        $blockchain = new Blockchain();

        //when
        $blockchain->addBlock(new Block());
        $blockchain->addBlock(new Block());

        //then
        $this->assertTrue($blockchain->isChainValid());
    }

}