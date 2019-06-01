<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */

$script = <<< JS
    //var keys = $('#grid').yiiGridView('getSelectedRows');
    //alert("Hi");
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>
<?php \yii\widgets\Pjax::begin() ?>
<?= Html::beginForm(['order/add-order-card'], 'post'); ?>
    <div class="pull-right">
        <?php echo Html::hiddenInput('order_id', $id) ?>
        <?php echo Html::submitButton('Thêm thẻ', ['class' => 'btn btn-success', 'id' => 'btn-add-card']) ?>
    </div>

    <div class="order-form">

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'id',
                ],
                [
                    'attribute' => 'card_type',
                    'options' => ['style' => 'width: 10%'],
                    'value' => function ($model) {
                        return $model->cardType ? $model->cardType->name : null;
                    },
                    'filter' => \yii\helpers\ArrayHelper::map(\common\models\CardType::find()->active()->all(), 'id', 'name'),
                ],
                'name',
                'description',
                'retail_price',
                'bonus_price',
                'raw_price',
                'rate_employee',
                // 'status',
                // 'created_at',
                // 'updated_at',
                // 'created_by',
                // 'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
<?= Html::endForm(); ?>
<?php \yii\widgets\Pjax::end() ?>