<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Service */
/* @var $form yii\bootstrap\ActiveForm */

$url = Yii::$app->request->baseUrl. '/service/update-product';
//$csrf = Yii::$app->request->getCsrfToken();
$script = <<< SCRIPT
    $('.btn-refresh').click(function(){
        var pid = $(this).data('pid');
        $.ajax({
        url: '$url',
        type: 'post',
        data: {
            productid: pid,
            serviceid:$(this).data('sid') ,
            amount: $("#input-"+pid).val(),
        },
        success: function (data) {
            console.log(data.search);
        }
        });
    });
SCRIPT;

$this->registerJs($script, \yii\web\View::POS_READY);

?>



<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
	        [
		        'attribute' => 'product_id',
		        'label' => 'Sản phẩm',
		        'options' => ['style' => 'width: 15%'],
		        'value' => function ($model) {
			        return $model->product ? $model->product->slug : null;
		        },
	        ],
            [
                'attribute' => 'product_id',
                'label' => 'Sản phẩm',
                'options' => ['style' => 'width: 30%'],
                'value' => function ($model) {
                    return $model->product ? $model->product->name : null;
                },
            ],
            [
                'attribute' => 'amount',
                'options' => ['style' => 'width: 20%'],
                'label' => 'Số lượng',
                'value' => function ($model) {
	                return '<div class="row"><div class="col-md-8">'.Html::input('input','input-'.$model->product_id,$model->amount,['id'=>'input-'.$model->product_id]).'</div><div class="col-md-4">'.Html::button('<i class="fa fa-refresh"></i>',
                            [ 'id'=> 'abc',
                             'class'=>'btn-refresh',
                             'data-pid'=>$model->product_id,
                             'data-sid'=>$model->service_id
                            ]).'</div></div>';
                },
                'format'=>'raw'
            ],

            [
                'attribute' => 'unit',
                'label' => 'Đơn vị',
            ],
            [
                'attribute' => 'money',
                'label' => 'Thành tiền',
                'options' => ['style' => 'width: 10%'],
                'value' => function ($model) {
                    return \Yii::$app->formatter->asCurrency($model->money, 'VND');
                },
            ],
            [
                'class' => 'demi\sort\SortColumn',
                'action' => 'change-sort', // optional
            ],
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

//            [
//                'class' => 'yii\grid\ActionColumn',
//                'options' => ['style' => 'width: 5%'],
//                'template' => '{delete}',
//            ],
        ],
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
