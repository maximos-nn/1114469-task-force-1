<?php

namespace TaskForce\import;

use Exception;
use SplFileObject;

class TextWriter
{
    protected $fileObj;

    public function __construct(string $destination)
    {
        if (!$destination) {
            throw new Exception('Не задано имя файла.');
        }

        try {
            $this->fileObj = new SplFileObject($destination, 'w');
        } catch (Exception $e) {
            throw new Exception('Не удалось записать в файл ' . $destination . ': ' . $e->getMessage());
        }
    }

    public function writeData(): iterable
    {
        while ($line = yield) {
            $this->fileObj->fwrite($line);
        }
    }

    public function writeGenerator(iterable $generator): void
    {
        foreach ($generator as $line) {
            $this->fileObj->fwrite($line);
        }
    }
}
