<?php
/* @var $this \yii\web\View */
/* @var $date mixed */
/* @var $gaid mixed */
/* @var $route string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use app\models\Gadata;
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= urldecode(Url::home()) ?>">GaServer</a>
    </div>
    <?php ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to([$route]),
        'options' => [
            'class' => 'nav navbar-form navbar-right',
        ],
    ]) ?>
        <div class="form-group">
            <label>Г/А</label>
            <?= Html::dropDownList('gaid', $gaid, Gadata::getGaidsFromAllTables(), [
                'class' => 'form-control',
                'prompt' => 'Выберите Г/А',
            ]) ?>
        </div>
        <div class="form-group">
            <label>Дата</label>
            <?= DatePicker::widget([
                'name' => 'date',
                'language' => 'ru',
                'value' => $date,
                'type' => DatePicker::TYPE_INPUT,
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Выберите дату',
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'endDate' => "+0D",
                ],
            ]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php foreach ($items as $item): ?>
                    <li>
                        <a class="<?= $item['cssClass'] ?> menu-chart-url"
                           href="<?= $item['url'] ?>">
                            <?= $item['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>