<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use app\models\Gadata;
use app\models\search\GadataSearch;
use app\models\search\GadataextSearch;
use app\models\search\BalanceSearch;
use app\models\search\CoordinatesSearch;

class GadataController extends Controller
{
    public $defaultAction = 'chart';

    public function beforeAction($action)
    {
        $gaid = Yii::$app->request->get('gaid', false);
        $date = Yii::$app->request->get('date', false);
        $route = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;

        switch ($action->id) {
            case 'device-parameters':
                if (!$gaid) {
                    Yii::$app->session->setFlash('gadataRoute', $route);
                    throw new BadRequestHttpException('Выберите Г/А');
                }
                break;
            case 'chart':
            case 'archive':
                if (!$gaid || !$date) {
                    Yii::$app->session->setFlash('gadataRoute', $route);
                    throw new BadRequestHttpException('Выберите дату и Г/А');
                }
                break;
        }

        return parent::beforeAction($action);
    }

    public function actionChart($date = null, $gaid = null)
    {
        return $this->render('chart', [
            'date' => $date,
            'gaid' => $gaid,
        ]);
    }

    public function actionArchive($date, $gaid)
    {
        $searchModel = new GadataSearch();
        $searchModel->FDATE = $date;
        $searchModel->GAID = $gaid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gaids' => Gadata::getGaids(),
        ]);
    }

    public function actionDeviceParameters($gaid) {
        $balanceSearchModel = new BalanceSearch();
        $balanceSearchModel->GAID = $gaid;
        $balanceDataProvider = $balanceSearchModel->search(Yii::$app->request->queryParams);

        $coordinatesSearchModel = new CoordinatesSearch();
        $coordinatesSearchModel->GAID = $gaid;
        $coordinatesDataProvider = $coordinatesSearchModel->search(Yii::$app->request->queryParams);

        $gadataextSearchModel = new GadataextSearch();
        $gadataextSearchModel->GAID = $gaid;
        $gadataextDataProvider = $gadataextSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('device-parameters', [
            'balanceSearchModel' => $balanceSearchModel,
            'balanceDataProvider' => $balanceDataProvider,
            'coordinatesSearchModel' => $coordinatesSearchModel,
            'coordinatesDataProvider' => $coordinatesDataProvider,
            'gadataextSearchModel' => $gadataextSearchModel,
            'gadataextDataProvider' => $gadataextDataProvider,
        ]);
    }
}
