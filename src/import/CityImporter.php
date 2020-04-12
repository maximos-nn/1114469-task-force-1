<?php

namespace TaskForce\import;

use TaskForce\import\AbstractImporter;

class CityImporter extends AbstractImporter
{
    private const CSV_FIELDS = ['city', 'lat', 'long'];
    private const DB_TABLE_FIELDS = ['name', 'latitude', 'longitude'];
    private const DB_TABLE_NAME = 'cities';

    public function import(): int
    {
        return $this->initTableImporter(self::DB_TABLE_NAME, self::CSV_FIELDS, self::DB_TABLE_FIELDS)->import();
    }
}
