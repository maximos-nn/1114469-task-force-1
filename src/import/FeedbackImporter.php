<?php

namespace TaskForce\import;

class FeedbackImporter extends AbstractImporter
{
    private const CSV_FIELDS = ['dt_add', 'rate', 'description'];
    private const DB_TABLE_FIELDS = ['creation_time', 'rate', 'comment', 'task_id'];
    private const DB_TABLE_NAME = 'task_feedbacks';

    public function import(): int
    {
        return $this->initTableImporter(self::DB_TABLE_NAME, self::CSV_FIELDS, self::DB_TABLE_FIELDS)->merge([$this, 'processFeedbackData']);
    }

    public function processFeedbackData(array $csvData, int $count): array
    {
        [$feedbackData] = $csvData;
        return array_merge($feedbackData, [$count]);
    }
}
