<?php

namespace app\components\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\BadRequestHttpException;

class AjaxFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if (Yii::$app->request->isAjax) {
            return parent::beforeAction($action);
        }

        throw new BadRequestHttpException();
    }
}