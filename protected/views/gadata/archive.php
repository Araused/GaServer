<?php

use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\date\DatePicker;

$gridColumns = [
    [
        'attribute' => 'GAID',
        'filter' => $gaids,
        'width' => '120px',
        'filterInputOptions' => [
            'disabled' => true,
            'class' => 'form-control',
        ],
    ],
    [
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
    ],
    'FTIME',
    'CO',
    'O2',
    'NO',
    'CO2',
    'CH4',
];

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GadataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $gaids array */
?>
<div class="gadata-index grid-margin">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'resizableColumns' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'kv-pjax-container',
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h3 class="panel-title"><i class="fa fa-table fa-fw"></i> Архив</h3>',
            'footer' => false,
        ],
        'export' => [
            'label' => 'Текущая страница',
            'fontAwesome' => true,
        ],
        'beforeHeader' => [
            '{pager}',
        ],
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'pjaxContainerId' => 'kv-pjax-container',
                'dropdownOptions' => [
                    'label' => 'Полностью',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Экспорт все данные</li>',
                    ],
                ],
                'onInitWriter' => function ($writer, $grid) {
                    //Костыль, другим способом поменять разделить ячеек для CSV без правки исходников не получилось
                    if (\Yii::$app->request->post(ExportMenu::PARAM_EXPORT_TYPE) == ExportMenu::FORMAT_CSV) {
                        $writer->setExcelCompatibility(true);
                    }
                },
            ]),
        ],
        'panelBeforeTemplate' => '<div class="pull-left">{pager}</div><div class="pull-right">Экспорт: {toolbar}</div><div class="clear"></div>',
    ]) ?>

</div>
