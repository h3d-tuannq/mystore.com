<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Hóa đơn trả nợ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-pay">

    <div class="order-form content">

        <?php $form = ActiveForm::begin( [
            //'layout'=>'horizontal',
            'options' => [
                'id' => 'create-order-form',
//            'fieldConfig' => [
//                'horizontalCssClasses' => [
//                    'label' => 'col-sm-3',
//                    'offset' => 'col-sm-offset-3',
//                    'wrapper' => 'col-sm-4',
//                ],
//            ],
            ]
        ] ); ?>

        <?php echo $form->errorSummary( $model ); ?>

        <?php if ( $model->id ) {
            echo $form->field( $model, 'code' )->textInput( [ 'maxlength' => true ] );
        } ?>
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->field($model, 'order_date')->widget(\kartik\datetime\DateTimePicker::className(),[
                    'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
                    //'value' => ,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-mm-yyyy HH:ii:ss'
                    ]
                ]); ?>
                <?php //echo $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

                <?php echo $form->field( $model, 'customer_id' )->widget( \kartik\select2\Select2::classname(), [
                    'data'          => \yii\helpers\ArrayHelper::map( \common\models\Customer::find()->select(['id','concat(slug," - ",name) as name'])->all(), 'id', 'name' ),
                    'options'       => [ 'placeholder' => 'Chọn khách hàng' ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ] );

                // Child # 1
                echo $form->field($model, 'order_id')->widget(DepDrop::classname(), [
                    'options'=>['id'=>'order-id'],
                    'pluginOptions'=>[
                        'depends'=>['order-customer_id'],
                        'placeholder'=>'Tìm hóa đơn ...',
                        'url'=>\yii\helpers\Url::to(['/order/find-order'])
                    ]
                ])->label('Trả cho hóa đơn');

                ?>

                <?php echo $form->field( $model, 'real_money' )->textInput( [ 'maxlength' => true ] )->label('Số tiền') ?>

            </div>

        </div>

        <div class="form-group">
            <?php echo Html::submitButton( $model->isNewRecord ? Yii::t( 'backend', 'Tạo hóa đơn' ) : Yii::t( 'backend', 'Update' ), [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
