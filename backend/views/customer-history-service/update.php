<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryService */

$this->title = 'Cập nhật lịch sử dịch vụ';
$this->params['breadcrumbs'][] = ['label' => 'Lịch sử dịch vụ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

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

                    <?php echo $form->field($model, 'service_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                        \common\models\Service::find()->where(['id' => $model->service_id])->all(),
                        'id',
                        'name'
                    ), ['id' => 'select-service']); ?>
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

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


