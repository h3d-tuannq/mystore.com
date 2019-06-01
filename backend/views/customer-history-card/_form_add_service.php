<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */
$url = Yii::$app->request->baseUrl . '/service/infos';
$script = <<< JS
    $("#btn-submit-service").on('click',function(){
        //console.log($("input[type=checkbox]:checked"));
        var serviceIds = "";
        $('#w2 input[name="id[]"]:checked').each(function() {
            if(serviceIds)
                serviceIds = serviceIds + ","+ this.value;
            else
                serviceIds = this.value;
        });
        //console.log(serviceIds);
        if(serviceIds){
            // Lấy thông tin service
            $.ajax({
                url: '$url',
                type: 'post',
                data: {
                    serviceIds: serviceIds,
                },
                success: function (data) {
                    $("#card-service-info-detail").append(data.detail);
                    serviceIds = '';
                }
            });
        }
        $('#modal-add-service').modal('toggle');
    });
    //var keys = $('#grid').yiiGridView('getSelectedRows');
    //alert("Hi");
JS;
$this->registerJs($script,\yii\web\View::POS_READY);
?>
<?php \yii\widgets\Pjax::begin() ?>
<div class="pull-right">
    <?php echo Html::submitButton('Thêm dịch vụ', ['class' => 'btn btn-success','id'=>'btn-submit-service']) ?>
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
                'attribute' => 'slug',
                'options' => ['style' => 'width: 10%'],
            ],
            'name',
            //'description:ntext',
            //'product_type_id',

            //'product_unit_id',
//            [
//                'attribute' => 'product_unit',
//                'label' => 'Đơn vị',
//            ],
            //'retail_price',
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