<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ReportProductSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="report-product-search">

    <?php $form = ActiveForm::begin([
        'layout' => 'inline',
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //echo $form->field($model, 'id') ?>

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
    <?php // echo $form->field($model, 'report_date') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
