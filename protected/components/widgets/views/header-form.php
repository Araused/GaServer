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
<?php ActiveForm::begin([
    'method' => 'get',
    'action' => Url::to([$route]),
    'options' => [
        'class' => 'nav navbar-form navbar-right',
    ],
]) ?>
    <div class="form-group">
        <label>Г/А</label>
        <?= Html::dropDownList('gaid', $gaid, Gadata::getGaids(), [
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