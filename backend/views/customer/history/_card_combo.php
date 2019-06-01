<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo Html::a('Thêm lịch sử thẻ', ['customer-history/create', 'customer_id' => $model->id,'type'=>'card'],
                ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php //\yii\widgets\Pjax::begin() ?>
    <div class="col-md-12">

        <?php if ($cDataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach ($cDataProvider->getModels() as $modelService): ?>
                    <?php if (!isset($date) || $date != Yii::$app->formatter->asDate($modelService->started_date)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?php echo Yii::$app->formatter->asDate($modelService->updated_at) ?>
                            </span>
                        </li>
                    <?php endif; ?>
                    <li>
                        <?php
                        if($modelService->object_type == 'card'){
                            echo $this->render('_item_card', ['model' => $modelService, 'customer_id' => $model->id]);
                        }else{
                            echo $this->render('_item_card_service', ['model' => $modelService, 'customer_id' => $model->id]);
                        }

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
            'pagination' => $cDataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>

    <?php //\yii\widgets\Pjax::end() ?>
</div>



