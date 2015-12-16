<?php
/* @var $this \yii\web\View */
?>
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