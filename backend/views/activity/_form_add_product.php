<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */
$url = Yii::$app->request->baseUrl . '/product/activity-infos';
$script = <<< JS
    $("#btn-add-submit-product").on('click',function(){
        //console.log($("input[type=checkbox]:checked"));
        var productIds = "";
        var serviceId = 0;
        $('.product-form input[name="id[]"]:checked').each(function() {
            if(productIds)
                productIds = productIds + ","+ this.value;
            else
                productIds = this.value;
        });
        //console.log(serviceIds);
        if(productIds){
            // Lấy thông tin service
            $.ajax({
                url: '$url',
                type: 'post',
                data: {
                    productIds: productIds,
                    serviceId: serviceId,
                },
                success: function (data) {
                    $("#product-info-detail").append(data.detail);
                    productIds = '';
                    serviceId = '';
                }
            });
        }
        $('#modal-add-product').modal('toggle');
    });
    //var keys = $('#grid').yiiGridView('getSelectedRows');
    //alert("Hi");
JS;
$this->registerJs($script,\yii\web\View::POS_READY);
?>
<?php \yii\widgets\Pjax::begin() ?>
<div class="pull-right">
    <?php echo Html::button('Thêm sản phẩm', ['class' => 'btn btn-success','id'=>'btn-add-submit-product']) ?>
</div>

<div class="product-form">


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
                'options' => ['style' => 'width: 20%'],
            ],
            'name',
            //'description:ntext',
            //'product_type_id',

            //'product_unit_id',
            [
                'attribute' => 'product_unit',
                'label' => 'Đơn vị',
            ],
            'input_price',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?= Html::endForm();?>
<?php \yii\widgets\Pjax::end() ?>