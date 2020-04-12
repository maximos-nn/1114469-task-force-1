<?php

namespace TaskForce\import;

class TableImporter
{
    private $reader;
    private $writer;
    private $tableName;
    private $tableFields;
    private $count = 0;

    private function writeData(iterable $reader): void
    {
        foreach ($reader as $item) {
            $this->writer->send($item);
        }
    }

    private function count(iterable $iterable): iterable
    {
        foreach ($iterable as $item) {
            ++$this->count;
            yield $item;
        }
    }

    private function chain(iterable ...$generators): iterable
    {
        foreach ($generators as $generator) {
            yield from $generator;
        }
    }

    private function isValid(iterable $iterable): bool
    {
        return $iterable->valid();
    }

    private function all(callable $predicate, iterable $iterable): bool
    {
        foreach ($iterable as $item) {
            if (!$predicate($item)) {
                return false;
            }
        }
        return true;
    }

    private function getCurrentData(array $readers): array
    {
        foreach ($readers as $reader) {
            $data[] = $reader->current();
        }
        return $data;
    }

    private function next(iterable $iterable): void
    {
        foreach ($iterable as $item) {
            $item->next();
        }
    }

    private function mergeReaders(callable $processDataCb, iterable ...$readers): iterable
    {
        while ($this->all([$this, 'isValid'], $readers)) {
            yield $processDataCb($this->getCurrentData($readers), $this->count);
            $this->next($readers);
        }
    }

    // Нужны интерфейсы.
    public function __construct(iterable $reader, iterable $writer, string $tableName ,array $tableFields)
    {
        $this->reader = $this->count($reader);
        $this->writer = $writer;
        $this->tableName = $tableName;
        $this->tableFields = $tableFields;
    }

    public function import(): int
    {
        $insertQuery = new InsertQueryBuilder($this->tableName, $this->tableFields, $this->reader);
        $clearQuery = new ClearTableQueryBuilder($this->tableName);
        $this->writeData($this->chain($clearQuery->readData(), $insertQuery->readData()));
        return $this->count;
    }

    public function merge(callable $processDataCb, iterable ...$readers): int
    {
        $this->reader = $this->mergeReaders($processDataCb, $this->reader, ...$readers);
        return $this->import();
    }
}
