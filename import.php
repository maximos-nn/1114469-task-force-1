<?php
require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\import\CsvReader;
use TaskForce\import\RandomInt;
use TaskForce\import\TableImporter;
use TaskForce\import\TextWriter;

function initTableImporter(string $file, string $table, array $csvFields, array $tableFields): TableImporter
{
    $reader = new CsvReader($file, $csvFields);
    $writer = new TextWriter($file . '.sql');
    return new TableImporter($reader->readData(), $writer->writeData(), $table, $tableFields);
}

function processProfileData(array $csvData, int $count): array
{
    [$profileData, $userData] = $csvData;
    return array_merge([$count], $userData, $profileData);
}

function processFeedbackData(array $csvData, int $count): array
{
    [$feedbackData] = $csvData;
    return array_merge($feedbackData, [$count]);
}

try {
    // Импортируем города.
    $file = 'data/cities.csv';
    $csvFields = ['city', 'lat', 'long'];
    $table = 'cities';
    $tableFields = ['name', 'latitude', 'longitude'];
    $importer = initTableImporter($file, $table, $csvFields, $tableFields);
    // Сохраняем количество городов.
    $citiesCount = $importer->import();

    $randomCity = new RandomInt(1, $citiesCount);

    // Импортируем категории.
    $file = 'data/categories.csv';
    $csvFields = ['name', 'icon'];
    $table = 'categories';
    $tableFields = ['name', 'alias'];
    $importer = initTableImporter($file, $table, $csvFields, $tableFields);
    // Сохраняем количество категорий.
    $categoriesCount = $importer->import();

    // Импортируем пользователей.
    // По идее, мы должны импортировать только $profilesCount записей.
    // Но нам заранее известно, что количество записей пользователей равно количеству записей профилей.
    // Поэтому импортируем полностью.
    $file = 'data/users.csv';
    $table = 'users';
    $fields = ['email', 'password'];
    $importer = initTableImporter($file, $table, $fields, $fields);
    $importer->import();

    // Импортируем профили.
    // Пользователи и профили связаны отношением один к одному.
    // Обрабатываем их синхронно.
    // Текстовое представление адреса не храним.
    $file = 'data/profiles.csv';
    $csvFields = ['bd', 'about', 'phone', 'skype'];
    $table = 'profiles';
    $tableFields = ['user_id', 'creation_time', 'name', 'city_id', 'birthday', 'info', 'phone', 'skype'];
    $usersFile = 'data/users.csv';
    $userCsvFields = ['dt_add', 'name'];
    // user_id и city_id - внешние ключи. Их нужно добавить.
    // creation_time и name берем из файла пользователей. Остальные поля из файла профилей.
    $importer = initTableImporter($file, $table, $csvFields, $tableFields);
    $usersReader = new CsvReader($usersFile, $userCsvFields);
    // Сохраняем количество профилей.
    $profilesCount = $importer->merge('processProfileData', $randomCity->append($usersReader->readData()));

    $randomUser = new RandomInt(1, $profilesCount);

    $profileIds = array_map(function (int $value) {
        return [$value];
    }, range(1, $profilesCount));
    // Создадим настройки профилей.
    $reader = new ArrayIterator($profileIds);
    $writer = new TextWriter('data/settings.sql');
    $importer = new TableImporter($reader, $writer->writeData(), 'profile_settings', ['profile_id']);
    $importer->import();
    // Создадим статистику профилей.
    $writer = new TextWriter('data/stats.sql');
    $importer = new TableImporter($reader, $writer->writeData(), 'profile_stats', ['profile_id']);
    $importer->import();

    // Импортируем задания. Текстовое представление адреса не храним.
    // Необходимо добавить идентификаторы заказчиков и городов.
    $file = 'data/tasks.csv';
    $csvFields = ['dt_add', 'category_id', 'description', 'expire', 'name', 'budget', 'lat', 'long'];
    $table = 'tasks';
    $tableFields = ['creation_time', 'category_id', 'description', 'expire_date', 'title', 'budget', 'latitude', 'longitude', 'city_id', 'profile_id'];
    $reader = new CsvReader($file, $csvFields);
    $finalReader = $randomUser->append($randomCity->append($reader->readData()));
    $writer = new TextWriter($file . '.sql');
    $importer = new TableImporter($finalReader, $writer->writeData(), $table, $tableFields);
    $tasksCount = $importer->import();

    $randomTask = new RandomInt(1, $tasksCount);

    // Импортируем отзывы заказчиков.
    // Должно быть импортировано не более $tasksCount записей.
    // Заранее известно, что количество отзывов равно количеству заданий.
    // Импортируем полностью.
    $file = 'data/opinions.csv';
    $csvFields = ['dt_add', 'rate', 'description'];
    $table = 'task_feedbacks';
    $tableFields = ['creation_time', 'rate', 'comment', 'task_id'];
    $importer = initTableImporter($file, $table, $csvFields, $tableFields);
    $importer->merge('processFeedbackData');

    // Импортируем отклики исполнителей.
    // Распределим их по заданиям случайно.
    // Необходимо убедиться, что идентификатор исполнителя не совпадает с идентификатором заказчика.
    // Также на одно задание должно быть по одному отклику исполнителя.
    // Опустим эти проверки и сгенерируем случайные идентификаторы исполнителей.
    // Либо дописывать в файл заведомо корректные данные.
    $file = 'data/replies.csv';
    $csvFields = ['dt_add', 'description'];
    $table = 'task_responses';
    $tableFields = ['creation_time', 'comment', 'task_id', 'profile_id'];
    $reader = new CsvReader($file, $csvFields);
    $finalReader = $randomUser->append($randomTask->append($reader->readData()));
    $writer = new TextWriter($file . '.sql');
    $importer = new TableImporter($finalReader, $writer->writeData(), $table, $tableFields);
    $importer->import();

    echo '<p>', '$citiesCount=' . $citiesCount, '</p>';
    echo '<p>', '$categoriesCount=' . $categoriesCount, '</p>';
    echo '<p>', '$profilesCount=' . $profilesCount, '</p>';
    echo '<p>', '$tasksCount=' . $tasksCount, '</p>';
} catch (\Throwable $th) {
    echo $th;
}
