<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $gaids array */
?>
<div class="gadata-index grid-margin">

    <div class="row">
        <div class="col-md-4">
            <h1>Газоанализаторы</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Номер г/а</th>
                    <th>Действие</th>
                </thead>
                <tbody>
                    <?php foreach ($gaids as $gaid): ?>
                        <?php $url = Url::toRoute(['admin/delete-gaid', 'gaid' => $gaid]) ?>
                        <tr>
                            <td>
                                <?= $gaid ?>
                            </td>
                            <td>
                                <?= Html::a('Удалить', $url, [
                                    'class' => 'btn btn-warning btn-xs',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
