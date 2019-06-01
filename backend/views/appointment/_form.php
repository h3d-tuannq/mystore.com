<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\bootstrap\ActiveForm */

$url = \yii\helpers\Url::to(['customer/list']);
// Get the initial city description
$customerName = empty($model->customer_id) ? '' : \common\models\Customer::findOne($model->customer_id)->name;
?>
<!-- /. box -->
<?php \yii\widgets\Pjax::begin() ?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <?php echo $model->isNewRecord ? '<h3 class="box-title"> Thêm Lịch hẹn </h3>' : '' ?>
        <div class="pull-right">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Đặt lịch') : Yii::t('backend', 'Cập nhật'), ['class' => 'btn btn-sm btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <div class="appointment-form">

            <?php //echo $form->errorSummary($model); ?>
            <?php echo $form->field($model, 'appointment_time')->widget(\kartik\datetime\DateTimePicker::className(), [
                //'name' => 'dp_2',
                'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
                //'value' => time(),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy hh:ii:ss'
                ]
            ]); ?>
            <?php echo $form->field($model, 'end_time')->widget(\kartik\datetime\DateTimePicker::className(), [
                //'name' => 'dp_2',
                'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
                //'value' => time(),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy hh:ii:ss'
                ]
            ]); ?>
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
            //                echo $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::classname(), [
            //                    'initValueText' => $customerName, // set the initial display text
            //                    'options' => ['placeholder' => 'Tìm kiếm khách hàng ...'],
            //                    'pluginOptions' => [
            //                        'allowClear' => true,
            //                        'minimumInputLength' => 0,
            //                        'language' => [
            //                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            //                        ],
            //                        'ajax' => [
            //                            'url' => $url,
            //                            'dataType' => 'json',
            //                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
            //                        ],
            //                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            //                        'templateResult' => new JsExpression('function(customer) { return customer.text; }'),
            //                        'templateSelection' => new JsExpression('function (customer) { return customer.text; }'),
            //                    ],
            //                ]);
            echo $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::classname(), [
                'initValueText' => $customerName, // set the initial display text
                'options' => ['placeholder' => 'Tìm trong ' . count($customers) . ' khách hàng'],
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
            ]);
            ?>
            <?php //echo $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
            <?php //echo $form->field($model, 'service_id')->textInput() ?>
            <?php //echo $form->field($model, 'appointment_time')->widget(\kartik\datetime\DateTimePicker::className(),[
            //        'name' => 'dp_2',
            //        'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
            //        'value' => '23-Feb-1982 10:01',
            //        'pluginOptions' => [
            //            'autoclose'=>true,
            //            'format' => 'dd-M-yyyy hh:ii'
            //        ]
            //]); ?>

            <?php //echo $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'service_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Service::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Chọn dịch vụ'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?php //echo $form->field($model, 'number_customer')->textInput() ?>
            <?php //echo $form->field($model, 'number_customer')->widget(\kartik\touchspin\TouchSpin::classname(), [
            //        'pluginOptions' => [
            //            'initval' => 1,
            //            'min' => 1,
            //            'max' => 100,
            //            'buttonup_class' => 'btn btn-success',
            //            //'buttondown_class' => 'btn btn-warning',
            //            'buttonup_txt' => '<i class="fa fa-plus"></i>',
            //            'buttondown_txt' => '<i class="fa fa-minus"></i>'
            //        ]
            //    ]); ?>

            <?php echo $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Chọn nhân viên'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?php //echo $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?php //echo $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

            <?php //echo $form->field($model, 'status')->textInput() ?>

            <?php //echo $form->field($model, 'created_at')->textInput() ?>

            <?php //echo $form->field($model, 'updated_at')->textInput() ?>

            <?php //echo $form->field($model, 'created_by')->textInput() ?>

            <?php //echo $form->field($model, 'updated_by')->textInput() ?>

            <div class="form-group">

            </div>


        </div>
        <!-- /input-group -->
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end() ?>
