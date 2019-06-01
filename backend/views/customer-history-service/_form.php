<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryService */
/* @var $form yii\bootstrap\ActiveForm */

$url = Yii::$app->request->baseUrl . '/service/info';

$script = <<< SCRIPT
    $("#select-service").on('change',function(){
    
    $.ajax({
        url: '$url',
        type: 'post',
        data: {
            service_id: $(this).val(),
            service_combo: '',
        },
        success: function (data) {
            
            $("#amount").val(data.total_price);
            if(data.service_type == 'combo'){
                $("#service-info").hide();
                $("#service-combo-info").show();
                $("#service-combo-info-detail").html(data.detail);
            }else{
                $("#service-combo-info").hide();
                $("#service-info").show();
                $("#service-info-detail").html(data.detail);
            }
        }
        });
        
    
    // and send it via an ajax request into your own url
    var valueOfMyGlobalAdminDropDown=$(this).val();
    if(valueOfMyGlobalAdminDropDown=="yes"){
       //DO SOMETHING
    }else{
       //DO SOMETHING ELSE
    }
});
SCRIPT;
$scriptLoad = <<< SCRIPT
    $("#select-service").change();
SCRIPT;
$this->registerJs($script, \yii\web\View::POS_READY);
$this->registerJs($scriptLoad, \yii\web\View::POS_LOAD);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="customer-history-service-form">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <?php echo $form->errorSummary($model); ?>

                    <?php if ($model->customer_id) {
                        echo $form->field($model, 'customer_id')->hiddenInput()->label(false);
                        echo '<h3>Khách hàng: ' . $model->customer_name . '</h3>';

                    } else {
                        echo $form->field($model, 'customer_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Customer::find()->all(),
                            'id',
                            'name'
                        ), ['prompt' => '']);

                    } ?>

                    <?php if ($isNew) {
                        echo $form->field($model, 'service_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Service::find()->all(),
                            'id',
                            'name'
                        ), ['prompt' => '', 'id' => 'select-service']);

                    }else{
                        echo $form->field($model, 'service_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Service::find()->where(['id'=>$model->service_id])->all(),
                            'id',
                            'name'
                        ), ['id' => 'select-service']);
                    }

                    ?>
                    <?php echo $form->field($model, 'started_date')->widget(
                        \trntv\yii\datetime\DateTimeWidget::class,
                        [
                            'phpDatetimeFormat' => 'yyyy-MM-dd',
                        ]
                    ) ?>
                    <?php echo $form->field($model, 'amount')->textInput(['id' => 'amount']) ?>

                    <?php echo $form->field($model, 'amount_use')->textInput() ?>

                    <?php echo $form->field($model, 'amount_remain')->textInput() ?>

                    <?php echo $form->field($model, 'note')->textarea(['rows' => 6]) ?>

                    <?php echo $form->field($model, 'status')->dropDownList(\common\models\Common::statuses()) ?>

                    <?php //echo $form->field($model, 'created_at')->textInput() ?>

                    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

                    <?php //echo $form->field($model, 'created_by')->textInput() ?>

                    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

                    <div class="form-group">
                        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-8">

            <!-- Thông tin cho service -->
            <div id="service-info" class="box box-success" style="display: none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin dịch vụ</h3>
                </div>
                <div class="box-body">
                    <div id="service-info-detail"></div>
                </div>
            </div>

            <div id="service-combo-info" class="box box-success" <?php $isNew ? 'style="display: none;"':''?>>
                <div class="box-header with-border">
                    <h3 class="box-title">Bao gồm các dịch vụ</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th width="15%">Mã</th>
                                    <th width="40%">Dịch vụ</th>
                                    <th width="10%">Số lượng</th>
                                    <th width="25%">Giá</th>
                                    <th width="10%">Thời gian</th>
                                </tr>
                                </thead>
                                <tbody id="service-combo-info-detail">
                                <?php
                                if ($model->service_combo) {
                                    $serviceIds = json_decode($model->service_combo);
                                    $detail = '';
                                    foreach ($serviceIds as $key => $value) {
                                        $service = \common\models\Service::findOne($key);
                                        if ($service) {

                                            $detail .= "<tr>";
                                            $detail .= "<td>" . $service->slug . " </td>";
                                            $detail .= "<td>" . $service->name . " </td>";
                                            $detail .= "<td><input type='text' class='form-control' name='CustomerHistoryCard[services][" . $service->id . "]'  value='" . $value . "' /></td>";
                                            $detail .= "<td>" . Yii::$app->formatter->asCurrency($service->retail_price, 'VND') . "  </td>";
                                            $detail .= "<td>" . $service->duration . " </td>";
                                            $detail .= "</tr>";
                                        }
                                    }
                                    if ($detail) {
                                        echo $detail;
                                    }
                                } ?>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


