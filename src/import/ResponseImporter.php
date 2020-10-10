<?php

namespace TaskForce\import;

class ResponseImporter
{
    private const CSV_FIELDS = ['dt_add', 'description'];
    private const DB_TABLE_FIELDS = ['creation_time', 'comment', 'task_id', 'user_id'];
    private const DB_TABLE_NAME = 'task_responses';

    private $file;
    private $randomTask;
    private $randomUser;

    public function __construct(string $file, RandomInt $randomTask, RandomInt $randomUser)
    {
        $this->file = $file;
        $this->randomTask = $randomTask;
        $this->randomUser = $randomUser;
    }

    public function import(): int
    {
        $reader = new CsvReader($this->file, self::CSV_FIELDS);
        $finalReader = $this->randomUser->append($this->randomTask->append($reader->readData()));
        $writer = new TextWriter($this->file . '.sql');
        $importer = new TableImporter($finalReader, $writer->writeData(), self::DB_TABLE_NAME, self::DB_TABLE_FIELDS);
        return $importer->import();
    }
}
