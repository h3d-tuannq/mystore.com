<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'service_id',
                'label' => 'Dịch vụ',
                'options' => ['style' => 'width: 20%'],
                'value' => function ($model) {
                    return $model->service ? $model->service->name : null;
                },
            ],
            [
                'attribute' => 'amount',
                'label' => 'Số lượng',
            ],

            [
                'attribute' => 'money',
                'label' => 'Thành tiền',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    if($model->money){
                        return \Yii::$app->formatter->asCurrency($model->money, 'VND');
                    }
                    return \Yii::$app->formatter->asCurrency(0, 'VND');
                },
            ],
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 10%'],
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
