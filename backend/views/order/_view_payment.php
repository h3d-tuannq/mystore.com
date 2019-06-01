<?php


?>
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="pull-left"><h3 class="box-title">Phương thức thanh toán</h3></div>

        <div class="pull-right">
            <?= \yii\helpers\Html::button('<i class="fa fa-plus"></i> Thêm thanh toán',
                [
                    'value' => \yii\helpers\Url::to(['order/add-payment','id'=>$model->id]),
                    'title' => 'Thêm thanh toán',
                    'class' => 'showModalButton btn btn-sm btn-primary',
                    'data-title' => 'Thêm phương thức thanh toán vào đơn hàng',
                ]); ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <?php foreach($model->orderPayment as $key=>$orderPayment){ ?>
            <tr>
                <td><?= ++$key ?></td>
                <td><?= $orderPayment->payment->name ?></td>
                <td><?= \Yii::$app->formatter->asCurrency($orderPayment->total_money, 'VND')  ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <!-- /.box-body -->
</div>



