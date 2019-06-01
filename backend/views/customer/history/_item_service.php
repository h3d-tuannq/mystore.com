<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */


?>
<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->updated_at) ?>
    </span>

    <h3 class="timeline-header">
        <?php echo "Dịch vụ lẻ: <b>" . $model->service->name . "</b>| ".$model->amount." buổi | Đã dùng ".$model->sub." buổi | Còn ".$model->remain." buổi" ?>
    </h3>

    <div class="timeline-body">
        <dl>
            <dd>
                <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Update'),
                    ['customer-history/update', 'id' => $model->id, 'customer_id' => $customer_id,'type'=>'service'],
                    ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
                <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Delete'), ['customer-history/delete', 'id' => $model->id, 'customer_id' => $customer_id], [
                    'class' => 'btn btn-danger btn-xs',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?></dd>
        </dl>

    </div>
</div>