<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\PaymentHistory */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="payment-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'customer_id')->textInput() ?>

    <?php echo $form->field($model, 'before_money')->textInput() ?>

    <?php echo $form->field($model, 'change_money')->textInput() ?>

    <?php echo $form->field($model, 'current_money')->textInput() ?>

    <?php echo $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'type')->textInput() ?>

    <?php echo $form->field($model, 'object_id')->textInput() ?>

    <?php echo $form->field($model, 'object_type')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
