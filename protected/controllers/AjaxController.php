<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use app\components\filters\AjaxFilter;
use app\models\Chart;

class AjaxController extends Controller
{
    public function behaviors()
    {
        return [
            'ajax' => [
                'class' => AjaxFilter::className(),
            ],
        ];
    }

    public function actionGetData($date = null, $gaid = null, $browserTime = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Chart;

        return $model->getData($date, $gaid, $browserTime);
    }
    
    public function actionGetChartUrl($gaid = null, $date = null)
    {
        return Url::toRoute([
            'gadata/chart',
            'gaid' => $gaid,
            'date' => $date,
        ]);
    }
}
