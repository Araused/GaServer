<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\Gadata;

class AdminController extends Controller
{
    public $defaultAction = 'gaids';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-gaid' => ['post'],
                ],
            ],
        ];
    }

    public function actionGaids()
    {
        return $this->render('gaids', [
            'gaids' => Gadata::getGaidsFromAllTables(),
        ]);
    }
    
    public function actionDeleteGaid($gaid)
    {
        Gadata::deleteGaidFromAllTables($gaid);
        return $this->redirect(['gaids']);
    }
}
