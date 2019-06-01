<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\bootstrap\ActiveForm */

$urlService = \yii\helpers\Url::to(['service/list']);
$url = \yii\helpers\Url::to(['customer/list']);
// Get the initial city description
$customerName = empty($model->customer_id) ? '' : \common\models\Customer::findOne($model->customer_id)->name;
$serviceName = empty($model->service_id) ? '' : \common\models\Service::findOne($model->service_id)->name;
?>

<div class="appointment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->errorSummary($model); ?>

    <?php //echo \kartik\typeahead\Typeahead::widget([
    //        'name' => 'country',
    //        'options' => ['placeholder' => 'Filter as you type ...'],
    //        'pluginOptions' => ['highlight'=>true],
    //        'dataset' => [
    //            [
    //                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
    //                'display' => 'value',
    //                //'prefetch' => $baseUrl . '/samples/countries.json',
    //                'remote' => [
    //                    'url' => \yii\helpers\Url::to(['customer/list']) . '?q=%QUERY',
    //                    'wildcard' => '%QUERY'
    //                ]
    //            ]
    //        ]
    //    ]); ?>

    <?php //echo $form->field($model, 'customer_id')->textInput() ?>
    <?php
    //var_dump($customers);die;
    echo $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::classname(), [
        'initValueText' => $customerName, // set the initial display text
        'options' => ['placeholder' => 'Tìm trong '.count($customers).' khách hàng'],
        'data' => $customers,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
//            'ajax' => [
//                'url' => $url,
//                'dataType' => 'json',
//                'data' => new JsExpression('function(params) { return {q:params.term}; }')
//            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(customer) { return customer.text; }'),
            'templateSelection' => new JsExpression('function (customer) { return customer.text; }'),
        ],
    ]); ?>
    <?php echo $form->field($model, 'start_time')->widget(\kartik\datetime\DateTimePicker::className(),[
        //'name' => 'dp_2',
        'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy hh:ii:ss'
        ]
    ]); ?>
    <?php echo $form->field($model, 'end_time')->widget(\kartik\datetime\DateTimePicker::className(),[
        //'name' => 'dp_2',
        'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
        'value' => time(),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy hh:ii:ss'
        ]
    ]); ?>

    <?php echo $form->field($model, 'service_id')->widget(\kartik\select2\Select2::classname(), [
        'initValueText' => $serviceName, // set the initial display text
        'options' => ['placeholder' => 'Tìm trong '.count($services).' dịch vụ'],
        'data' => $services,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
//            'ajax' => [
//                'url' => $urlService,
//                'dataType' => 'json',
//                'data' => new JsExpression('function(params) { return {q:params.term}; }')
//            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(service) { return service.text; }'),
            'templateSelection' => new JsExpression('function (service) { return service.text; }'),
        ],
    ]); ?>

    <?php //echo $form->field($model, 'employee_id')->textInput() ?>
    <?php echo $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::classname(), [
        'data' =>  \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Chọn nhân viên'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php echo $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'bed')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Đặt lịch') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
