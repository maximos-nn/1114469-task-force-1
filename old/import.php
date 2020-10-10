<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use TaskForce\import\CategoryImporter;
use TaskForce\import\CityImporter;
use TaskForce\import\FeedbackImporter;
use TaskForce\import\ProfileImporter;
use TaskForce\import\RandomInt;
use TaskForce\import\ResponseImporter;
use TaskForce\import\TaskImporter;
use TaskForce\import\UserImporter;

try {
    $cityImporter = new CityImporter('../data/cities.csv');
    $citiesCount = $cityImporter->import();

    $randomCity = new RandomInt(1, $citiesCount);

    $categoryImporter = new CategoryImporter('../data/categories.csv');
    $categoriesCount = $categoryImporter->import();

    $userImporter = new UserImporter('../data/users.csv', '../data/profiles.csv', $randomCity);
    $usersCount = $userImporter->import();

    $randomUser = new RandomInt(1, $usersCount);

    $taskImporter = new TaskImporter('../data/tasks.csv', $randomCity, $randomUser);
    $tasksCount = $taskImporter->import();

    $randomTask = new RandomInt(1, $tasksCount);

    (new FeedbackImporter('../data/opinions.csv'))->import();

    (new ResponseImporter('../data/replies.csv', $randomTask, $randomUser))->import();

} catch (\Throwable $th) {
    echo $th;
}
