<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="box box-primary">
    <div class="box-header">
        <h5>Số dư: <?php echo Yii::$app->formatter->asCurrency($model->account_money?:0, 'VND') ?>
        <div class="pull-right">
            <?php echo Html::a('Mua dịch vụ', ['buy','customer_id'=>$model->id], ['class' => 'btn btn-sm btn-success']) ?>
        </div>
        </h5>
    </div>

    <div class="box-body">
        <p>Các dịch vụ hiện có:</p>

    </div>
</div>

