<?php

use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProductSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="product-search">

	<?php $form = ActiveForm::begin( [
		'layout' => 'inline',
		'action' => [ 'customer' ],
		'method' => 'get',
	] ); ?>
    <div class="row">
        <div class="col-md-4">

			<?php echo $form->field( $model, 'customer_code' )->textInput( [ 'placeholder' => 'Mã khách hàng' ] ) ?>

			<?php //echo $form->field( $model, 'customer_name' )->textInput( [ 'placeholder' => 'Tên khách hàng' ] ) ?>
        </div>
        <div class="col-md-5">
			<?php echo DatePicker::widget( [
                'model' => $model,
                'attribute' => 'from',
                'attribute2' => 'to',
				'value'         => date('d/m/Y', time()),
				'type'          => DatePicker::TYPE_RANGE,
				'value2'        => date('d/m/Y', time()),
				'pluginOptions' => [
					'autoclose' => true,
				]
			] ); ?>
        </div>

        <div class="col-md-3">
            <div class="form-group">
		        <?php echo Html::submitButton( Yii::t( 'backend', 'Search' ), [ 'class' => 'btn btn-primary' ] ) ?>
		        <?php echo Html::resetButton( Yii::t( 'backend', 'Reset' ), [ 'class' => 'btn btn-default' ] ) ?>
            </div>
        </div>
    </div>

    <br/>


	<?php ActiveForm::end(); ?>

</div>
