<?php

use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\search\ProductSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['service-month'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'service_code')->textInput(['placeholder' => 'Mã dịch vụ']) ?>

            <?php //echo $form->field( $model, 'customer_name' )->textInput( [ 'placeholder' => 'Tên khách hàng' ] ) ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($model, 'year')->dropDownList(['2019' => '2019', '2018' => '2018'],['placeholder' => 'Chọn  ...', 'prompt' => 'Năm']) ?>
            <?php echo $form->field($model, 'month')->dropDownList(['1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            ],['placeholder' => 'Chọn  ...', 'prompt' => 'Tháng']) ?>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <br/>


    <?php ActiveForm::end(); ?>

</div>
