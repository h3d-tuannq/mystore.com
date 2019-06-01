<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistory */

$this->title = 'Thêm lịch sử dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Lịch sử khách hàng'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

$url = \yii\helpers\Url::to(['service/list']);
?>
<div class="customer-history-create">

    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
	                <?php echo Html::a(Yii::t('backend', '<- Khách hàng'), ['customer/view','id'=>$model->customer_id], ['class' => 'btn btn-success']) ?>
                    <?php $form = ActiveForm::begin(); ?>

                    <?php echo $form->errorSummary($model); ?>

                    <?php if ($model->customer_id) {
                        echo $form->field($model, 'customer_id')->hiddenInput()->label(false);
                        echo '<h3>Khách hàng: ' . $model->customer->name . '</h3>';

                    } else {
                        echo $form->field($model, 'customer_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Customer::find()->all(),
                            'id',
                            'name'
                        ), ['prompt' => '']);

                    } ?>

                    <?php echo $form->field($model, 'object_id')->widget(\kartik\select2\Select2::classname(), [
                       // 'initValueText' => $customerName, // set the initial display text
                        'options' => ['placeholder' => 'Tìm kiếm dịch vụ ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 0,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => $url,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(service) { return service.text; }'),
                            'templateSelection' => new JsExpression('function (service) { return service.text; }'),
                        ],
                    ]); ?>



                    <?php echo $form->field($model, 'started_date')->widget(
                        \trntv\yii\datetime\DateTimeWidget::class,
                        [
                            'phpDatetimeFormat' => 'yyyy-MM-dd',
                        ]
                    ) ?>
                    <?php echo $form->field($model, 'amount')->textInput()->label('Tổng số buổi') ?>
                    <?php echo $form->field($model, 'sub')->textInput()->label('Số buổi đã dùng') ?>
                    <?php echo $form->field($model, 'remain')->textInput()->label('Số buổi còn lại') ?>

                    <?php echo $form->field($model, 'note')->textarea(['rows' => 6])->label('Ghi chú') ?>

                    <?php echo $form->field($model, 'status')->dropDownList(\common\models\Common::statuses()) ?>


                    <div class="form-group">
                        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
        <div class="col-md-8">

            <!-- Thông tin cho service -->
            <div id="service-info" class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin dịch vụ</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 table-responsive">
                        <?php
                        if ($model->details) {
                            echo '<ul>';
                            foreach ($model->details as $detail) {
                                echo '<li>Ngày ' . Yii::$app->formatter->asDate($detail->used_at) . ': '.$detail->note.' : '. $detail->amount.'</li>';
                            }
                            echo '</ul>';
                        } ?>
                    </div>
                    <!-- /.col -->
                </div>
            </div>

        </div>
    </div>

</div>