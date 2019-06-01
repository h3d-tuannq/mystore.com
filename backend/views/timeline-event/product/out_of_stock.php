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
        <?php echo isset($model->data['content'])? $model->data['content'] : ''  ?>
    </h3>

    <div class="timeline-body">
        <p>Mã sản phẩm: <?php echo isset($model->data['product_code']) ? $model->data['product_code'] : $model->data['product_id']?></p>
    </div>

    <div class="timeline-footer">
        <?php echo \yii\helpers\Html::a(
            Yii::t('backend', 'Xem sản phẩm'),
            ['product/view', 'id' => $model->data['product_id']],
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>