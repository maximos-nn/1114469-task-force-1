<?php

namespace TaskForce\import;

class UserImporter extends AbstractImporter
{
    private const DB_TABLE_FIELDS = ['email', 'password'];
    private const DB_TABLE_NAME = 'users';

    public function import(): int
    {
        return $this->initTableImporter(self::DB_TABLE_NAME, self::DB_TABLE_FIELDS, self::DB_TABLE_FIELDS)->import();
    }
}
