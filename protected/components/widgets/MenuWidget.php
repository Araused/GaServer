<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class MenuWidget extends Widget
{
    private $items = [
        'chart' => [
            'label' => '<i class="fa fa-bar-chart-o fa-fw"></i> График',
            'url' => 'gadata/chart',
            'cssClass' => '',
        ],
        'archive' => [
            'label' => '<i class="fa fa-table fa-fw"></i> Архив',
            'url' => 'gadata/archive',
            'cssClass' => '',
        ],
        'device-parameters' => [
            'label' => '<i class="fa fa-cog fa-fw"></i> Параметры',
            'url' => 'gadata/device-parameters',
            'cssClass' => '',
        ],
    ];

    public function run()
    {
        $gaid = Yii::$app->request->get('gaid');
        $date = Yii::$app->request->get('date');
        $route = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
        $items = $this->items;

        if (Yii::$app->session->hasFlash('gadataRoute')) {
            $route = Yii::$app->session->getFlash('gadataRoute');
        }

        foreach ($this->items as $key => $item) {
            if (Yii::$app->controller->action->id == $key) {
                $items[$key]['cssClass'] = 'active';
            }

            $items[$key]['url'] = urldecode(Url::toRoute([
                $items[$key]['url'],
                'date' => $date,
                'gaid' => $gaid,
            ]));
        }

        return $this->render('menu', [
            'items' => $items,
            'date' => $date,
            'gaid' => $gaid,
            'route' => $route,
        ]);
    }
}