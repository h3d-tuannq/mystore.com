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
        <?php echo $model->service ? $model->service->slug . ' - <b>' . $model->service->name . '</b>' : '' ?>
        <?php if ($model->service && 'combo' == $model->service->serviceType->slug) {
            if ($model->service_combo_text) {
                $texts = json_decode($model->service_combo_text);
                echo '<ul>';
                foreach ($texts as $text) {
                    if($text->time) {
                        echo '<li>' . $text->service . ', Số lần sử dụng: ' . $text->time . '</li>';
                    }
                }
                echo '</ul>';
            }
        } ?>

        <?php echo $model->note ?>
    </h3>

    <div class="timeline-body">
        <dl>
            <dt><?php echo Yii::t('backend', 'Giá trị') ?>
                : <?php echo Yii::$app->formatter->asCurrency($model->amount ?: 0, 'VND') ?></dt>
            <dt>Sử dụng: <?php echo $model->amount_use ?></dt>
            <dd>Tồn: <?php echo $model->amount_remain ?></dd>
            <dd>
                <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Update'),
                    ['customer-history-service/update', 'id' => $model->id, 'customer_id' => $customer_id],
                    ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
                <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Delete'), ['customer-history-service/delete', 'id' => $model->id, 'customer_id' => $customer_id], [
                    'class' => 'btn btn-danger btn-xs',
                    'data' => [
                        'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?></dd>
        </dl>

    </div>
</div>