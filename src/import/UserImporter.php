<?php

namespace TaskForce\import;

class UserImporter extends AbstractImporter
{
    private const CSV_FIELDS = ['email', 'name', 'password', 'dt_add'];
    private const DB_TABLE_FIELDS = ['email', 'name', 'password', 'creation_time', 'birthday', 'info', 'phone', 'skype', 'city_id'];
    private const DB_TABLE_NAME = 'users';
    private const CSV_PROFILE_FIELDS = ['bd', 'about', 'phone', 'skype'];
    private const DB_RELATIVE_FIELDS = ['user_id'];
    private const DB_SETTINGS_NAME = 'user_settings';
    private const DB_STATS_NAME = 'user_stats';

    private $profilesFile;
    private $randomCity;

    public function __construct(string $usersFile, string $profilesFile, RandomInt $randomCity)
    {
        $this->file = $usersFile;
        $this->profilesFile = $profilesFile;
        $this->randomCity = $randomCity;
    }

    public function import(): int
    {
        $importer = $this->initTableImporter(self::DB_TABLE_NAME, self::CSV_FIELDS, self::DB_TABLE_FIELDS);
        $profilesReader = new CsvReader($this->profilesFile, self::CSV_PROFILE_FIELDS);
        $usersCount = $importer->merge([$this, 'processUserData'], $this->randomCity->append($profilesReader->readData()));
        $this->generateRelativeData($usersCount);
        return $usersCount;
    }

    public function processUserData(array $csvData, int $count): array
    {
        [$userData, $profileData] = $csvData;
        return array_merge($userData, $profileData);
    }

    private function writeTable(iterable $reader, string $file, string $tableName)
    {
        $writer = new TextWriter($file);
        $importer = new TableImporter($reader, $writer->writeData(), $tableName, self::DB_RELATIVE_FIELDS);
        $importer->import();
    }

    private function generateRelativeData(int $count)
    {
        $profileIds = array_map(function (int $value) {
            return [$value];
        }, range(1, $count));
        $reader = new \ArrayIterator($profileIds);

        $this->writeTable($reader, $this->file . '.settings.sql', self::DB_SETTINGS_NAME);
        $this->writeTable($reader, $this->file . '.stats.sql', self::DB_STATS_NAME);
    }
}
