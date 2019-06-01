<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo Html::a('Thêm lịch sử dịch vụ', ['customer-history-service/create', 'customer_id' => $model->id],
                ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php //\yii\widgets\Pjax::begin() ?>
    <div class="col-md-12">

        <?php if ($serviceDataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach ($serviceDataProvider->getModels() as $modelService): ?>
                    <?php if (!isset($date) || $date != Yii::$app->formatter->asDate($modelService->started_date)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?php echo Yii::$app->formatter->asDate($modelService->started_date) ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <li>
                        <?php
                        echo $this->render('_item', ['model' => $modelService, 'customer_id' => $model->id]);
                        ?>
                    </li>

                <?php endforeach; ?>
                <li>
                    <i class="fa fa-clock-o">
                    </i>
                </li>
            </ul>
        <?php else: ?>
            <?php echo Yii::t('backend', 'No events found') ?>
        <?php endif; ?>
    </div>
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $serviceDataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>

    <?php //\yii\widgets\Pjax::end() ?>
</div>



