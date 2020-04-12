<?php

namespace TaskForce\import;

class CategoryImporter extends AbstractImporter
{
    private const CSV_FIELDS = ['name', 'icon'];
    private const DB_TABLE_FIELDS = ['name', 'alias'];
    private const DB_TABLE_NAME = 'categories';

    public function import(): int
    {
        return $this->initTableImporter(self::DB_TABLE_NAME, self::CSV_FIELDS, self::DB_TABLE_FIELDS)->import();
    }
}
