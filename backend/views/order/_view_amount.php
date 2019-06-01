<?php
/* @var $model common\models\Order */
?>
<div class="view-amount">

    <p class="lead">Thành tiền</p>

    <div class="table-responsive">
        <table class="table">
            <tbody>
            <tr>
                <th style="width:60%">Thành tiền:</th>
                <th><?= \Yii::$app->formatter->asCurrency($model->raw_money, 'VND') ?>
            </tr>
            <tr>
                <th>Chiết khấu (<?= \Yii::$app->formatter->asPercent($model->discount/100, 0) ?>)</th>
                <th><?= \Yii::$app->formatter->asCurrency($model->raw_money - $model->total_money, 'VND') ?></th>
            </tr>
<!--            <tr>-->
<!--                <th>Voucher</th>-->
<!--                <th>150.000đ</th>-->
<!--            </tr>-->
            <tr>
                <th>Tổng tiền:</th>
                <th><?= \Yii::$app->formatter->asCurrency($model->total_money, 'VND') ?></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>
