<?php

use yii\helpers\Html;

?>

<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo Html::a('Thêm lịch sử thẻ', ['customer-history-card/create', 'customer_id' => $model->id],
                ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php //\yii\widgets\Pjax::begin() ?>
    <div class="col-md-12">

        <?php if ($cardDataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach ($cardDataProvider->getModels() as $modelCard): ?>
                    <?php if (!isset($date) || $date != Yii::$app->formatter->asDate($modelCard->started_date)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?php echo Yii::$app->formatter->asDate($modelCard->started_date) ?>
                            </span>
                        </li>
                        <?php $date = Yii::$app->formatter->asDate($modelCard->started_date) ?>
                    <?php endif; ?>
                    <li>
                        <?php
                        echo $this->render('_item_card', ['model' => $modelCard, 'customer_id' => $model->id]);
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
            'pagination' => $cardDataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>
    <?php //\yii\widgets\Pjax::end() ?>

</div>


