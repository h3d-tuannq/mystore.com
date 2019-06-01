<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\OrderSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>


    <?php $form = ActiveForm::begin([
        //'layout' => 'inline',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?php echo $form->field($model, 'from')->widget(
        \trntv\yii\datetime\DateTimeWidget::class,
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd',
        ]
    ) ?>
    <?php echo $form->field($model, 'to')->widget(
        \trntv\yii\datetime\DateTimeWidget::class,
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd',
        ]
    ) ?>
    <?php //echo $form->field($model, 'id') ?>

    <?php //echo $form->field($model, 'code') ?>

    <?php echo $form->field($model, 'customer_id') ?>

    <?php //echo $form->field($model, 'discount') ?>

    <?php //echo $form->field($model, 'rate_receptionist') ?>

    <?php // echo $form->field($model, 'rate_employee_id') ?>

    <?php // echo $form->field($model, 'raw_money') ?>

    <?php // echo $form->field($model, 'total_money') ?>

    <?php // echo $form->field($model, 'real_money') ?>

    <?php // echo $form->field($model, 'payment_type') ?>

    <?php // echo $form->field($model, 'voucher_code') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

