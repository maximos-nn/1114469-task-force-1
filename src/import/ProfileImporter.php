<?php

namespace TaskForce\import;

class ProfileImporter extends AbstractImporter
{
    private const CSV_FIELDS = ['bd', 'about', 'phone', 'skype'];
    private const DB_TABLE_FIELDS = ['user_id', 'creation_time', 'name', 'city_id', 'birthday', 'info', 'phone', 'skype'];
    private const DB_TABLE_NAME = 'profiles';
    private const CSV_USER_FIELDS = ['dt_add', 'name'];
    private const DB_RELATIVE_FIELDS = ['profile_id'];
    private const DB_SETTINGS_NAME = 'profile_settings';
    private const DB_STATS_NAME = 'profile_stats';

    private $usersFile;
    private $randomCity;

    public function __construct(string $profilesFile, string $usersFile, RandomInt $randomCity)
    {
        $this->file = $profilesFile;
        $this->usersFile = $usersFile;
        $this->randomCity = $randomCity;
    }

    public function import(): int
    {
        $importer = $this->initTableImporter(self::DB_TABLE_NAME, self::CSV_FIELDS, self::DB_TABLE_FIELDS);
        $usersReader = new CsvReader($this->usersFile, self::CSV_USER_FIELDS);
        $profilesCount = $importer->merge([$this, 'processProfileData'], $this->randomCity->append($usersReader->readData()));
        $this->generateRelativeData($profilesCount);
        return $profilesCount;
    }

    public function processProfileData(array $csvData, int $count): array
    {
        [$profileData, $userData] = $csvData;
        return array_merge([$count], $userData, $profileData);
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
