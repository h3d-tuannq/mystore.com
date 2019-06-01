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
//$this->registerJs($script, \yii\web\View::POS_READY);
?>

<?= Html::beginForm(['service/add-product'], 'post'); ?>
    <div class="pull-right">
        <?php echo Html::hiddenInput('service_id', $id) ?>
        <?php echo Html::submitButton('Thêm sản phẩm', ['class' => 'btn btn-success', 'id' => 'btn-add-product']) ?>
    </div>

    <div class="product-form">
        <?php \yii\widgets\Pjax::begin() ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'name' => 'id',
                ],
                [
                    'attribute' => 'slug',
                    'options' => ['style' => 'width: 10%'],
                ],
                [
                    'attribute' => 'product_type',
                    'label' => 'Kiểu',
                ],
                'name',
                //'description:ntext',
                //'product_type_id',

                //'product_unit_id',
                [
                    'attribute' => 'product_unit',
                    'label' => 'Đơn vị',
                ],
                'retail_price',
                // 'rate_employee',
                // 'status',
                // 'thumbnail_base_url:url',
                // 'thumbnail_path',
                // 'created_at',
                // 'updated_at',
                // 'created_by',
                // 'updated_by',
                // 'product_date',
                // 'product_time_use:datetime',
                // 'is_notification',

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end() ?>
    </div>
<?= Html::endForm(); ?>
