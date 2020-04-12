<?php

namespace TaskForce\import;

use Exception;

class ClearTableQueryBuilder
{
    protected $tableName;

    public function __construct(string $tableName)
    {
        if (!$tableName) {
            throw new Exception('Не указано имя таблицы.');
        }
        $this->tableName = $tableName;
    }

    public function readData(): iterable
    {
        $command = 'SET FOREIGN_KEY_CHECKS = 0;';
        $command .= PHP_EOL;
        $command .= 'TRUNCATE TABLE';
        $command .= ' `' . $this->tableName . '`';
        $command .= ';' . PHP_EOL;
        $command .= 'SET FOREIGN_KEY_CHECKS = 1;';
        $command .= PHP_EOL;
        yield $command;
    }
}
