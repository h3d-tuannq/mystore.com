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
<?= Html::beginForm(['order/add-order-service'], 'post'); ?>
    <div class="pull-right">
        <?php echo Html::hiddenInput('order_id', $id) ?>
        <?php echo Html::submitButton('Thêm dịch vụ', ['class' => 'btn btn-success', 'id' => 'btn-add-service']) ?>
    </div>

    <div class="order-form">

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'id',
                ],
                [
                    'attribute' => 'slug',
                    'options' => ['style' => 'width: 10%'],
                ],
                [
                    'attribute' => 'service_type_id',
                    'options' => ['style' => 'width: 10%'],
                    'value' => function ($model) {
                        return $model->serviceType ? $model->serviceType->name : null;
                    },
                    'filter' => \yii\helpers\ArrayHelper::map(\common\models\ServiceType::find()->all(), 'id', 'name'),
                ],
                [
                    'attribute' => 'name',
                    'options' => ['style' => 'width: 30%'],
                ],
                [
                    'attribute' => 'duration',
                    'options' => ['style' => 'width: 5%'],
                    'value' => function ($model) {
                        if ($model->duration) {
                            return "$model->duration p";
                        }
                        return '0 phút';
                    }
                ],
                [
                    'attribute' => 'total_price',
                    'options' => ['style' => 'width: 8%'],
                    'value' => function ($model) {
                        if($model->total_price){
                            return \Yii::$app->formatter->asCurrency($model->total_price, 'VND');
                        }
                        return \Yii::$app->formatter->asCurrency(0, 'VND');
                    },
                ],
                [
                    'attribute' => 'retail_price',
                    'options' => ['style' => 'width: 10%'],
                    'value' => function ($model) {
                        if($model->retail_price){
                            return \Yii::$app->formatter->asCurrency($model->retail_price, 'VND');
                        }
                        return \Yii::$app->formatter->asCurrency(0, 'VND');
                    },
                ],

//                [
//                    'class' => 'yii\grid\ActionColumn',
//                    'options' => ['style' => 'width: 10%'],
//                    'template' => '{view} {update} {delete}',
//                ],
            ],
        ]); ?>

    </div>
<?= Html::endForm(); ?>
<?php \yii\widgets\Pjax::end() ?>