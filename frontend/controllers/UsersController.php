<?php

namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\Tasks;

class UsersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $subquery = Tasks::find()
        ->select(['COUNT(*)'])
        ->joinWith('taskFeedbacks', true, 'INNER JOIN')
        ->where('contractor_id = u.id');

        $users = Users::find()
        ->alias('u')
        ->select(['u.*', 'feedbacks' => $subquery])
        ->joinWith('categories cat', true, 'INNER JOIN')
        ->joinWith('userStats st', true, 'INNER JOIN')
        ->orderBy('u.creation_time DESC')
        ->all();
        return $this->render('index', ['users' => $users]);
    }

}
