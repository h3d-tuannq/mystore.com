<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\search\ReportPaymentSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="report-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-3">

            <?php echo $form->field($model, 'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\Payment::find()->all(),'id','name'),[
                        'prompt'=>'Chọn phương thức thanh toán',
            ])
                ->label(false) ?>
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
    <?php //echo $form->field($model, 'id') ?>



    <?php //echo $form->field($model, 'payment_name') ?>

    <?php //echo $form->field($model, 'year') ?>

    <?php //echo $form->field($model, 'quarter') ?>

    <?php // echo $form->field($model, 'month') ?>

    <?php // echo $form->field($model, 'week') ?>

    <?php // echo $form->field($model, 'report_date') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php //echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php //echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
