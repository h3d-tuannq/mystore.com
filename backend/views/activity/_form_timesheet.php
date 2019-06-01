<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->errorSummary($model); ?>
    <?php echo $form->field($model, 'off')->checkbox(); ?>
    <?php echo $form->field($model, 'timesheet_date')->widget(\kartik\datetime\DateTimePicker::className(),[
        //'name' => 'dp_2',
        'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
        //'value' => time(),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy hh:ii:ss'
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'start_time')->widget(\kartik\time\TimePicker::className(),[
                //'name' => 'dp_2',
                //'type' => \kartik\time\TimePicker::,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'showMeridian' => false,
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'end_time')->widget(\kartik\time\TimePicker::className(),[
                //'name' => 'dp_2',
                //'type' => \kartik\time\TimePicker::,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'showMeridian' => false,
                ]
            ]); ?>
        </div>
    </div>

    <?php //echo $form->field($model, 'employee_id')->textInput() ?>
    <?php echo $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::classname(), [
        'data' =>  \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Chọn nhân viên'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php //echo $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Chấm công') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
