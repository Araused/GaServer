<?php

use kartik\grid\GridView;
use kartik\date\DatePicker;
use app\models\Balance;
use app\models\Coordinates;
use app\models\Gadataext;

$dateColumn = [
    'attribute' => 'FDATE',
    'value' => 'FDATE',
    'filterType' => GridView::FILTER_DATE,
    'filterWidgetOptions' => [
        'type' => DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'endDate' => "+0D",
        ],
    ],
    'format' => 'html',
];

$dateColumnDisabled = [
    'attribute' => 'FDATE',
    'value' => 'FDATE',
    'format' => 'html',
    'filterInputOptions' => [
        'disabled' => true,
        'class' => 'form-control',
    ],
];

/* @var $this yii\web\View */
/* @var $balanceSearchModel app\models\search\BalanceSearch */
/* @var $balanceDataProvider yii\data\ActiveDataProvider */
/* @var $coordinatesSearchModel app\models\search\CoordinatesSearch */
/* @var $coordinatesDataProvider yii\data\ActiveDataProvider */
/* @var $gadataextSearchModel app\models\search\GadataextSearch */
/* @var $gadataextDataProvider yii\data\ActiveDataProvider */
?>
<div class="device-parameters-index grid-margin">
    
    <?= GridView::widget([
        'dataProvider' => $gadataextDataProvider,
        'filterModel' => $gadataextSearchModel,
        'columns' => [
            [
                'attribute' => 'GAID',
                'filter' => Gadataext::getGaids(),
                'width' => '120px',
                'filterInputOptions' => [
                    'disabled' => true,
                    'class' => 'form-control',
                ],
            ],
            $dateColumn,
            'KO2',
            'KCO',
            'KNO',
            'K11',
            'KCO2',
            'KCH4',
            'KSO2',
        ],
        'resizableColumns' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'gadataext-pjax-container',
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="fa fa-table fa-fw"></i> Коэффициенты</h3>',
            'footer' => false,
        ],
        'beforeHeader' => [
            '{pager}',
        ],
        'panelBeforeTemplate' => '<div>{pager}</div>',
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= GridView::widget([
                'dataProvider' => $balanceDataProvider,
                'filterModel' => $balanceSearchModel,
                'columns' => [
                    [
                        'attribute' => 'GAID',
                        'filter' => Balance::getGaids(),
                        'width' => '120px',
                        'filterInputOptions' => [
                            'disabled' => true,
                            'class' => 'form-control',
                        ],
                    ],
                    $dateColumnDisabled,
                    [
                        'attribute' => 'BAL',
                        'filterInputOptions' => [
                            'disabled' => true,
                            'class' => 'form-control',
                        ],
                    ],
                ],
                'resizableColumns' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'options' => [
                        'id' => 'balance-pjax-container',
                    ],
                ],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="fa fa-table fa-fw"></i> Баланс</h3>',
                    'footer' => false,
                ],
                'beforeHeader' => [
                    '{pager}',
                ],
                'panelBeforeTemplate' => '<div>{pager}</div>',
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= GridView::widget([
                'dataProvider' => $coordinatesDataProvider,
                'filterModel' => $coordinatesSearchModel,
                'columns' => [
                    [
                        'attribute' => 'GAID',
                        'filter' => Coordinates::getGaids(),
                        'width' => '120px',
                        'filterInputOptions' => [
                            'disabled' => true,
                            'class' => 'form-control',
                        ],
                    ],
                    $dateColumnDisabled,
                    [
                        'attribute' => 'longitude',
                        'filterInputOptions' => [
                            'disabled' => true,
                            'class' => 'form-control',
                        ],
                    ],
                    [
                        'attribute' => 'latitude',
                        'filterInputOptions' => [
                            'disabled' => true,
                            'class' => 'form-control',
                        ],
                    ],
                ],
                'resizableColumns' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'options' => [
                        'id' => 'coordinates-pjax-container',
                    ],
                ],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<h3 class="panel-title"><i class="fa fa-table fa-fw"></i> Координаты</h3>',
                    'footer' => false,
                ],
                'beforeHeader' => [
                    '{pager}',
                ],
                'panelBeforeTemplate' => '<div>{pager}</div>',
            ]) ?>
        </div>
    </div>

</div>
