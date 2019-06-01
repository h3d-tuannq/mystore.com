<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\bootstrap\ActiveForm */

$urlService = \yii\helpers\Url::to(['service/list']);
$this->title = 'Mua dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-create">

    <div class="customer-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">

                        <?php echo $form->field($model, 'service_id')->widget(\kartik\select2\Select2::classname(), [
                            //'initValueText' => $serviceName, // set the initial display text
                            'options' => ['placeholder' => 'Tìm kiếm dịch vụ ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 0,
                                'language' => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax' => [
                                    'url' => $urlService,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(service) { return service.text; }'),
                                'templateSelection' => new JsExpression('function (service) { return service.text; }'),
                            ],
                        ]); ?>
                        <?php echo $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group">
            <?php echo Html::submitButton( Yii::t('backend', 'Create') , ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
