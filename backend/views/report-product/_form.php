<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\ReportProduct */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="report-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'product_id')->textInput() ?>

    <?php echo $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'year')->textInput() ?>

    <?php echo $form->field($model, 'quarter')->textInput() ?>

    <?php echo $form->field($model, 'month')->textInput() ?>

    <?php echo $form->field($model, 'week')->textInput() ?>

    <?php echo $form->field($model, 'report_date')->textInput() ?>

    <?php echo $form->field($model, 'revenue')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'updated_by')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
