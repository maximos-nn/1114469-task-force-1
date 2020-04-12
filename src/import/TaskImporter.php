<?php

namespace TaskForce\import;

class TaskImporter
{
    private const CSV_FIELDS = ['dt_add', 'category_id', 'description', 'expire', 'name', 'budget', 'lat', 'long'];
    private const DB_TABLE_FIELDS = ['creation_time', 'category_id', 'description', 'expire_date', 'title', 'budget', 'latitude', 'longitude', 'city_id', 'profile_id'];
    private const DB_TABLE_NAME = 'tasks';

    private $file;
    private $randomCity;
    private $randomUser;

    public function __construct(string $file, RandomInt $randomCity, RandomInt $randomUser)
    {
        $this->file = $file;
        $this->randomCity = $randomCity;
        $this->randomUser = $randomUser;
    }

    public function import(): int
    {
        $reader = new CsvReader($this->file, self::CSV_FIELDS);
        $finalReader = $this->randomUser->append($this->randomCity->append($reader->readData()));
        $writer = new TextWriter($this->file . '.sql');
        $importer = new TableImporter($finalReader, $writer->writeData(), self::DB_TABLE_NAME, self::DB_TABLE_FIELDS);
        return $importer->import();
    }
}
