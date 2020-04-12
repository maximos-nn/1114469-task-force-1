<?php

namespace TaskForce\import;

use Exception;
use SplFileObject;
use TaskForce\Utils;

class CsvReader
{
    protected $fields;
    protected $fileObj;
    protected $fileHeader;
    protected $fieldsMap;

    public function __construct(string $source, array $fields)
    {
        if (!Utils::validateStringArray($fields)) {
            throw new Exception('Неверные поля данных.');
        }
        $this->fields = $fields;

        try {
            $this->fileObj = new SplFileObject($source);
        } catch (Exception $e) {
            throw new Exception('Не удалось прочитать файл ' . $source . ': ' . $e->getMessage());
        }
        $this->fileObj->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);

        $this->readHeader();
        if (!$this->validateHeaderFields()) {
            throw new Exception('В файле отсутствуют указанные поля.');
        }

        $this->getFiledsMap();
    }

    private function readHeader(): void
    {
        $this->fileHeader = $this->fileObj->current();
        if (!$this->fileHeader) {
            throw new Exception('Не удалось прочитать заголовок.');
        }
        $this->fileObj->next();
    }

    private function validateHeaderFields(): bool
    {
        return count(array_diff($this->fields, $this->fileHeader)) === 0;
    }

    public function readData(): iterable
    {
        while ($this->fileObj->valid()) {
            yield $this->getFieldsData($this->fileObj->current());
            $this->fileObj->next();
        }
    }

    private function getFieldsData(array $row): array
    {
        foreach ($this->fieldsMap as $index) {
            // Может быть несуществующий индекс.
            $result[] = $row[$index];
        }
        return $result;
    }

    private function getColumnIndex(string $fieldName): int
    {
        return array_search($fieldName, $this->fileHeader);
    }

    private function getFiledsMap(): void
    {
        $this->fieldsMap = array_map([$this, 'getColumnIndex'], $this->fields);
    }
}
