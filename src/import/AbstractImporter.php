<?php

namespace TaskForce\import;

abstract class AbstractImporter
{
    protected $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    protected function initTableImporter(string $table, array $csvFields, array $tableFields): TableImporter
    {
        $reader = new CsvReader($this->file, $csvFields);
        $writer = new TextWriter($this->file . '.sql');
        return new TableImporter($reader->readData(), $writer->writeData(), $table, $tableFields);
    }

    abstract public function import(): int;
}
