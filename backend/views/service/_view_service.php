<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\OrderDetail;

/* @var $model common\models\Order */

$services = \common\models\ServiceMix::findAll(['service_mix_id' => $model->id]);

$url = Yii::$app->request->baseUrl . '/service/update-service';
//$csrf = Yii::$app->request->getCsrfToken();
$script = <<< SCRIPT
    $('.btn-service-refresh').click(function(){
        var smid = $(this).data('smid');
        var sid = $(this).data('sid');
        $.ajax({
        url: '$url',
        type: 'post',
        data: {
            service_mix_id: smid,
            service_id:sid ,
            amount: $("#input-"+sid).val(),
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
                <th>Dịch vụ</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($services as $service) {
                if (!$service->service) {
                    \common\models\ServiceMix::find()->where(['service_mix_id'=>$service->service_mix_id,'service_id'=>$service->service_id])->one()->delete();
                    continue;
                }
                ?>
                <tr>
                    <td><?= $service->service->slug ?></td>
                    <td><?= $service->service->name ?></td>
                    <td>
                        <?php echo Html::input('input', 'input-' . $service->service_id, $service->amount,
                            [
                                'id' => 'input-' . $service->service_id,
                                'style' => 'width:70%',
                            ]);
                        echo Html::button('<i class="fa fa-refresh"></i>',
                            [
                                'class' => 'btn-service-refresh',
                                'style' => 'width:30%',
                                'data-smid' => $service->service_mix_id,
                                'data-sid' => $service->service_id
                            ]) ?>
                    </td>
                    <td><?= \Yii::$app->formatter->asCurrency($service->service->total_price, 'VND') ?>
                    <td><?= \Yii::$app->formatter->asCurrency($service->money, 'VND') ?>
                    </td>
                    <td>
                        <?= \yii\helpers\Html::a('<i class="fa fa-minus-circle text-red"></i> Xóa',
                            ['service/remove-service', 'id' => $model->id, 'service_id' => $service->service_id]); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->

</div>
