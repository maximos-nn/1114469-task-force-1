<?php

namespace frontend\controllers;

use frontend\models\Profiles;
use frontend\models\Tasks;

class UsersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $subquery = Tasks::find()
        ->select(['COUNT(*)'])
        ->joinWith('taskFeedbacks', true, 'INNER JOIN')
        ->where('contractor_id = p.id');

        $users = Profiles::find()
        ->alias('p')
        ->select(['p.*', 'cat.name as category', 'st.*', 'feedbacks' => $subquery])
        ->joinWith('categories cat', true, 'INNER JOIN')
        ->joinWith('profileStats st', true, 'INNER JOIN')
        ->orderBy('p.creation_time DESC')
        ->all();
        return $this->render('index', ['users' => $users]);
    }

}
