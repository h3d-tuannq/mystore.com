<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\OrderDetail;

/* @var $model common\models\Order */

$services = \common\models\base\CardService::findAll(['card_id' => $model->id]);
//var_dump($model->id);
//var_dump($services);die;
$url = Yii::$app->request->baseUrl . '/card/update-service';

$script = <<< SCRIPT
    $('.btn-card-refresh').click(function(){
        var cid = $(this).data('cid');
        var sid = $(this).data('sid');
        $.ajax({
        url: '$url',
        type: 'post',
        data: {
            card_id: cid,
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
                <th width="35%">Dịch vụ</th>
                <th width="15%">Số buổi</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($services as $service) {
                if (!$service->service) {
                    \common\models\base\CardService::find()->where(['card_id'=>$model->id,'service_id'=>$service->service_id])->one()->delete();
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
                                'class' => 'btn-card-refresh',
                                'style' => 'width:30%',
                                'data-cid' => $model->id,
                                'data-sid' => $service->service_id
                            ]) ?>
                    </td>
                    <td><?= \Yii::$app->formatter->asCurrency($service->service->retail_price ? : 0, 'VND') ?>
                    <td><?= \Yii::$app->formatter->asCurrency($service->money, 'VND') ?>
                    </td>
                    <td>
                        <?= \yii\helpers\Html::a('<i class="fa fa-minus-circle text-red"></i> Xóa',
                            ['card/remove-service', 'id' => $model->id, 'service_id' => $service->service_id]); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.col -->

</div>
