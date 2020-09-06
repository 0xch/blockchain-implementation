<?php

namespace Blockchain;

class PersistBlockchain
{
    const FIELDS_DELIMITER = ';';
    const FILENAME_PREFIX = 'blockchain_save';

    protected $fullFilename;

    public function __construct()
    {
        $this->fullFilename = __DIR__ . '/../saves/' . self::FILENAME_PREFIX . '.json';
    }

    public function saveBlockchain(Blockchain $blockchain): void
    {
        $content = $this->saveFileContent($blockchain->getChain());
        file_put_contents($this->fullFilename, $content);
    }

    private function saveFileContent(array $blocks): string
    {
        $content = [];
        foreach ($blocks as $block) {
            /** @var Block $block */
            $content[] = implode(self::FIELDS_DELIMITER, $block->toFields());
        }

        return implode(PHP_EOL, $content);
    }

    public function loadChain(): array
    {
        $chain = [];
        $content = file_get_contents($this->fullFilename);
        $rows = explode(PHP_EOL, $content);
        foreach ($rows as $row) {
            if (strlen($row) > 1) {
                $fields = explode(self::FIELDS_DELIMITER, trim($row));
                $chain[] = Block::createFromFields($fields);
            }
        }

        return $chain;
    }

    public function resetFile(): void
    {
        file_put_contents($this->fullFilename, null);
    }
}