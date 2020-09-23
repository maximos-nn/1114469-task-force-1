<?php

namespace frontend\controllers;

use frontend\models\Tasks;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasks = Tasks::find()
        ->joinWith('category')
        ->joinWith('city')
        ->where('expire_date > NOW() and assign_time is null')
        ->orderBy('creation_time DESC')
        ->all();
        return $this->render('index', ['tasks' => $tasks]);
    }

}
