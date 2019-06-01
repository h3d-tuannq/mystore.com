<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\OrderDetail;

/* @var $model common\models\Order */

$orderDetails = OrderDetail::find()->where(['order_id' => $model->id])->active()->all();
$url = Yii::$app->request->baseUrl . '/order/update-product ';
$url_service = Yii::$app->request->baseUrl . '/order/update-service ';
$url_card = Yii::$app->request->baseUrl . '/order/update-card ';
//$csrf = Yii::$app->request->getCsrfToken();
$script = <<< SCRIPT
    $('.btn-refresh').click(function(){
        var objectid = $(this).data('objectid');
        var orderid = $(this).data('orderid');
        $.ajax({
        url: '$url',
        type: 'post',
        data: {
            objectid: objectid,
            orderid: orderid ,
            amount: $("#input-"+objectid).val(),
        },
        success: function (data) {
            console.log(data.search);
        }
        });
    });
    
    $('.btn-refresh-card').click(function(){
        var objectid = $(this).data('objectid');
        var orderid = $(this).data('orderid');
        $.ajax({
        url: '$url_card',
        type: 'post',
        data: {
            objectid: objectid,
            orderid: orderid ,
            amount: $("#input-"+objectid).val(),
        },
        success: function (data) {
            console.log(data.search);
        }
        });
    });
    
        $('.btn-refresh-service').click(function(){
        var objectid = $(this).data('objectid');
        var orderid = $(this).data('orderid');
        $.ajax({
        url: '$url_service',
        type: 'post',
        data: {
            objectid: objectid,
            orderid: orderid ,
            amount: $("#input-"+objectid).val(),
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
                <th>Kiểu</th>
                <th>Sản phẩm & dịch vụ</th>
                <th>Số lượng</th>
                <th>Mã</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderDetails as $orderDetail) { ?>
                <tr>
                    <td>
                        <?php
                        if ($orderDetail->isService()) {
                            $classButonRefresh = 'btn-refresh-service';
                            echo 'Dịch vụ';
                        } else if ($orderDetail->isCard()) {
                            $classButonRefresh = 'btn-refresh-card';
                            echo 'Thẻ';
                        } else {
                            $classButonRefresh = 'btn-refresh';
                            echo 'Sản phẩm';
                        }
                        ?>
                    </td>
                    <?php
                    $slug = '';
                    if ('service' == $orderDetail->object_type) {
                        if($orderDetail->service) {
                            $slug = $orderDetail->service->slug;
                            echo '<td>' . $orderDetail->service->name . '</td>';
                        }
                    } else if ('card' == $orderDetail->object_type) {
                        if($orderDetail->card) {
                            $slug = $orderDetail->card->slug;
                            echo '<td>' . $orderDetail->card->name . '</td>';
                        }
                    } else {
                        if($orderDetail->product){
                            $slug = $orderDetail->product->slug;
                            echo '<td>' . $orderDetail->product->name . '</td>';
                        }

                    }
                    ?>

                    <td>
                        <?php echo Html::input('input', 'input-' . $orderDetail->object_id, $orderDetail->quantity,
                            [
                                'id' => 'input-' . $orderDetail->object_id,
                                'style' => 'width:70%',
                            ]);
                        echo Html::button('<i class="fa fa-refresh"></i>',
                            [
                                'class' => $classButonRefresh,
                                'style' => 'width:30%',
                                'data-objectid' => $orderDetail->object_id,
                                'data-orderid' => $orderDetail->order_id
                            ]) ?>
                    </td>
                    <td><?= $slug ?></td>
                    <td><?= \Yii::$app->formatter->asCurrency($orderDetail->unit_money, 'VND') ?>
                    <td><?= \Yii::$app->formatter->asCurrency($orderDetail->total_money, 'VND') ?>
                    </td>
                    <td>
                        <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Delete'), ['remove', 'id' => $model->id,'object_id'=>$orderDetail->object_id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->

</div>
