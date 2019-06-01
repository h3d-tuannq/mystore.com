<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
?>
<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>

    <h3 class="timeline-header">
        <?php
        $cusomer = \common\models\Customer::findOne($model->data['customer_id']);
        $code = '';
        if($cusomer){
            $code = $cusomer->slug . ' - ';
        }
        echo $code . $model->data['content'] ?>
    </h3>

    <div class="timeline-body">
        <p>Số điện thoại: <?php echo $model->data['customer_phone'] ?></p>
    </div>

    <div class="timeline-footer">
        <?php

        echo \yii\helpers\Html::a(
            Yii::t('backend', 'Xem khách hàng'),
            ['customer/view', 'id' => $model->data['customer_id']],
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>