<?php
/* @var $this yii\web\View */
/* @var $date mixed */
/* @var $gaid mixed */
/* @var $model Chart */

use yii\helpers\Url;
use app\assets\Ie8Asset;

Ie8Asset::register($this);

$route = ['/ajax/get-data', 'gaid' => $gaid];

if ($date != null) {
    $route['date'] = $date;
}

$url = Url::toRoute($route, true);

$currentDate = date('Y-m-d');
if ($date == null) {
    $date = $currentDate;
}

$enableAutoUpdate = 0;
if (Yii::$app->params['enableAutoUpdate']) {
    $enableAutoUpdate = $date == $currentDate ? 1 : 0;
}
?>
<div class="site-index"
     id="site-index"
     data-charturl="<?= urldecode($url) ?>"
     data-useinterval="<?= $enableAutoUpdate ?>"
     data-updateinterval="<?= Yii::$app->params['updateInterval'] ?>"
     data-interval="<?= Yii::$app->params['xAxesInterval'] ?>">

    <div class="chart"></div>

</div>
