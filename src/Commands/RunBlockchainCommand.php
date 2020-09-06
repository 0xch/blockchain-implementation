<?php

namespace Blockchain\Commands;

use Blockchain\Block;
use Blockchain\Blockchain;
use Blockchain\BlockMining;
use Blockchain\Difficult;
use Blockchain\PersistBlockchain;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunBlockchainCommand extends Command
{
    protected static $defaultName = 'app:run';

    protected function configure()
    {
        $this
            ->setDescription('Run main blockchain service')
            ->addArgument('new', InputArgument::OPTIONAL, 'Run a blockchain');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $persist = new PersistBlockchain();
        if ($input->getArgument('new')) {
            $persist->resetFile();
        }

        $chain = $persist->loadChain();
        $blockchain = new Blockchain(new BlockMining(new Difficult()), $chain);
        for ($i = 0; $i <= 100; $i++) {
            $pre = time();
            $blockchain->addBlock(new Block());
            $persist->saveBlockchain($blockchain);
            $post = time();
            $output->writeln('Added and mined block [' . $blockchain->getLastBlock()->getIndex() . '] in ' . ($post - $pre) . 'sec');
        }

        return 0;
    }
}