<?php

namespace Tests\Unit;

use Blockchain\Block;
use Blockchain\Blockchain;
use Blockchain\BlockMining;
use Blockchain\PersistBlockchain;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\DifficultTestMock;

class BlockchainTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNewBlockchainContainsGenesisBlock()
    {
        //when
        $blockchain = new Blockchain(new BlockMining(new DifficultTestMock()));

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
        $blockchain = new Blockchain(new BlockMining(new DifficultTestMock()));

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
        $blockchain = new Blockchain(new BlockMining(new DifficultTestMock()));

        //when
        $blockchain->addBlock(new Block());
        $blockchain->addBlock(new Block());

        //then
        $this->assertTrue($blockchain->isChainValid());
    }

    /**
     * @test
     */
    public function shouldSaveAndLoadBlockchain()
    {
        //given
        $persist = new PersistBlockchain();
        $blockchain = new Blockchain(new BlockMining(new DifficultTestMock()));
        $blockchain->addBlock(new Block());
        $blockchain->addBlock(new Block());

        //when
        $persist->saveBlockchain($blockchain);
        $chain = $persist->loadChain();
        $loadedBlockchain = new Blockchain(new BlockMining(new DifficultTestMock()), $chain);

        //then
        $this->assertEquals($blockchain, $loadedBlockchain);
    }

}