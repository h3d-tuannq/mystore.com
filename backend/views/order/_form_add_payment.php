<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */

$script = <<< JS
    //var keys = $('#grid').yiiGridView('getSelectedRows');
    //alert("Hi");
JS;
$this->registerJs($script,\yii\web\View::POS_READY);
?>

<div class="order-form">
    <?php \yii\widgets\Pjax::begin() ?>

    <?php $form = ActiveForm::begin([
        //'layout'=>'horizontal',
        'options' => [
            'id' => 'add-payment-form',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-3',
                    'wrapper' => 'col-sm-4',
                ],
            ],
        ]
    ]); ?>
    <table class="table table-bordered">
        <?php foreach ($payments as $payment){

            if(isset($order_payments[$payment->id])){
                $value = $order_payments[$payment->id];
            }else{
                $value = 0;
            }
            ?>
            <tr>
                <td><?= Html::label($payment->name,$payment->slug); ?></td>
                <td><?= Html::textInput("AddPaymentForm[payment][$payment->slug]",$value,['id'=>$payment->slug]) ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="form-group text-center">
        <?php echo Html::hiddenInput('AddPaymentForm[orderId]', $id) ?>
        <?php echo Html::submitButton('Thêm', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
