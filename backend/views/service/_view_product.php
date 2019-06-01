<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\OrderDetail;

/* @var $model common\models\Order */

$serviceProducts = \common\models\ServiceProduct::findAll(['service_id' => $model->id]);

$url = Yii::$app->request->baseUrl . '/service/update-product';
//$csrf = Yii::$app->request->getCsrfToken();
$script = <<< SCRIPT
    $('.btn-refresh').click(function(){
        var pid = $(this).data('pid');
        $.ajax({
        url: '$url',
        type: 'post',
        data: {
            productid: pid,
            service_id:$(this).data('sid') ,
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
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Mã</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn vị</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($serviceProducts as $serviceProduct) {
                if(!$serviceProduct->product){
                    $m = \common\models\ServiceProduct::find(['service_id' => $model->id,'product_id' => $serviceProduct->product_id,])->one();
                    if($m){
                        $m->delete();
                    }
                    continue;
                }
                ?>
                <tr>
                    <td><?= $serviceProduct->product->slug ?></td>
                    <td><?= $serviceProduct->product->name ?></td>
                    <td>
                        <?php echo Html::input('input', 'input-' . $serviceProduct->product_id, $serviceProduct->amount,
                            [
                                'id' => 'input-' . $serviceProduct->product_id,
                                'style' => 'width:70%',
                            ]);
                        echo Html::button('<i class="fa fa-refresh"></i>',
                            [
                                'class' => 'btn-refresh',
                                'style' => 'width:30%',
                                'data-pid' => $serviceProduct->product_id,
                                'data-sid' => $serviceProduct->service_id
                            ]) ?>
                    </td>
                    <td><?= $serviceProduct->unit ?></td>
                    <td><?= \Yii::$app->formatter->asCurrency($serviceProduct->product->input_price, 'VND') ?>
                    <td><?= \Yii::$app->formatter->asCurrency($serviceProduct->money, 'VND') ?>
                    </td>
                    <td>
                        <?= \yii\helpers\Html::a('<i class="fa fa-minus-circle text-red"></i> Xóa',
                            ['service/remove', 'id' => $model->id, 'product_id' => $serviceProduct->product_id]); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->

</div>
