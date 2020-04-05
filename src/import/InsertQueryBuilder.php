<?php

namespace TaskForce\import;

use Exception;
use TaskForce\Utils;

class InsertQueryBuilder
{
    protected $tableName;
    protected $fields;
    protected $reader;

    public function __construct(string $tableName, array $fields, iterable $reader)
    {
        if (!$tableName) {
            throw new Exception('Не указано имя таблицы.');
        }
        $this->tableName = $tableName;

        if (!Utils::validateStringArray($fields)) {
            throw new Exception('Неверные поля данных.');
        }
        $this->fields = $fields;

        $this->reader = $reader;
    }

    public function readData(): iterable
    {
        if (!$this->reader->valid()) {
            echo 'Not valid.';
            return;
        }
        $command = 'INSERT INTO';
        $command .= ' `' . $this->tableName . '`';
        $command .= $this->buildFieldsList();
        yield $command . PHP_EOL;
        yield 'VALUES' . PHP_EOL;
        yield $this->buildValuesList($this->reader->current());
        $this->reader->next();
        while ($this->reader->valid()) {
            yield ',' . PHP_EOL . $this->buildValuesList($this->reader->current());
            $this->reader->next();
        }
        yield ';' . PHP_EOL;
    }

    private function buildFieldsList(): string
    {
        return ' (`' . implode('`, `', $this->fields) . '`) ';
    }

    private function buildValuesList(array $row): string
    {
        return ' (\'' . implode('\', \'', $row) . '\')';
    }
}
