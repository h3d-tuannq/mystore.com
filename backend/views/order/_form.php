<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */
?>

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
	        ] ); ?>

            <div class="input-group">
                <?php echo $form->field( $model, 'discount', [
                    'template' => '{label}<div class="input-group">
                            {input}
                        <span class="input-group-addon">%</span>
                        </div>'
                ] )->textInput( [ 'class' => 'form-control' ] ) ?>
            </div>

            <?php echo $form->field( $model, 'voucher_code' )->textInput( [ 'maxlength' => true ] ) ?>

			<?php //echo $form->field($model, 'rate_receptionist')->textInput(['maxlength' => true]) ?>

			<?php //echo $form->field($model, 'rate_receptionist_id')->textInput(['maxlength' => true]) ?>

        </div>



        <div class="col-md-6">

            <div class="row">
                <div class="col-md-12"><h5>Chiết khấu cho lễ tân</h5></div>
                <div class="col-md-7">
                    <?php echo $form->field( $model, 'rate_receptionist_id' )->widget( \kartik\select2\Select2::classname(), [
                        'data'          => \yii\helpers\ArrayHelper::map( \common\models\Employee::getReceptions(), 'id', 'name' ),
                        'options'       => [ 'placeholder' => 'Chọn lễ tân' ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ] ); ?>

                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <?php echo $form->field( $model, 'rate_receptionist', [
                            'template' => '{label}<div class="input-group">
                            {input}
                        <span class="input-group-addon">%</span>
                        </div>'
                        ] )->textInput( [ 'class' => 'form-control' ] ) ?>
                    </div>
                </div>
            </div>


			<?php //echo $form->field($model, 'rate_employee')->textInput(['maxlength' => true]) ?>



            <div class="row">
                <div class="col-md-12"><h5>Chiết khấu cho nhân viên dịch vụ</h5></div>
                <div class="col-md-7">
					<?php echo $form->field( $model, 'rate_employee_id' )->widget( \kartik\select2\Select2::classname(), [
						'data'          => \yii\helpers\ArrayHelper::map( \common\models\Employee::getEmployees(), 'id', 'name' ),
						'options'       => [ 'placeholder' => 'Chọn nhân viên' ],
						'pluginOptions' => [
							'allowClear' => true
						],
					] ); ?>

                </div>
                <div class="col-md-5">
                    <div class="input-group">
						<?php echo $form->field( $model, 'rate_employee', [
							'template' => '{label}<div class="input-group">
                            {input}
                        <span class="input-group-addon">%</span>
                    </div>'
						] )
						                ->textInput( [ 'class' => 'form-control' ] ) ?>
                    </div>
                </div>
            </div>


			<?php //echo $form->field($model, 'rate_employee_id')->textInput() ?>


			<?php //echo $form->field($model, 'raw_money')->textInput() ?>

			<?php //echo $form->field($model, 'total_money')->textInput() ?>

			<?php //echo $form->field($model, 'real_money')->textInput() ?>

			<?php //echo $form->field($model, 'payment_type')->textInput() ?>


        </div>
    </div>


	<?php //echo $form->field($model, 'status')->textInput() ?>

	<?php //echo $form->field($model, 'created_at')->textInput() ?>

	<?php //echo $form->field($model, 'updated_at')->textInput() ?>

	<?php //echo $form->field($model, 'created_by')->textInput() ?>

	<?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group text-center">
		<?php echo Html::submitButton( $model->isNewRecord ? Yii::t( 'backend', 'Tạo hóa đơn' ) : Yii::t( 'backend', 'Update' ), [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
