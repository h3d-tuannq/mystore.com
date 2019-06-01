<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryCard */

$this->title = 'Cập nhật lịch sử thẻ';
$this->params['breadcrumbs'][] = ['label' => 'Lịch sử thẻ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

?>

<?php $form = ActiveForm::begin(); ?>
<div class="customer-history-card-form">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <?php echo $form->errorSummary($model); ?>

                    <?php if ($model->customer_id) {
                        echo $form->field($model, 'customer_id')->hiddenInput()->label(false);
                        echo '<h2>Khách hàng: ' . $model->customer_name . '</h2>';

                    } else {
                        echo $form->field($model, 'customer_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Customer::find()->all(),
                            'id',
                            'name'
                        ), ['prompt' => '']);

                    } ?>

                    <?php
                        echo $form->field($model, 'card_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Card::find()->where(['id' => $model->card_id])->all(),
                            'id',
                            'name'
                        ), ['id' => 'select-card']);

                    ?>


                    <?php echo $form->field($model, 'started_date')->widget(
                        \trntv\yii\datetime\DateTimeWidget::class,
                        [
                            'phpDatetimeFormat' => 'yyyy-MM-dd',
                        ]
                    ) ?>

                    <?php echo $form->field($model, 'amount')->textInput(['id' => 'amount'])->label('Tổng số buổi'); ?>

                    <?php echo $form->field($model, 'sub_money')->textInput()->label('Số buổi đã sử dụng') ?>

                    <?php echo $form->field($model, 'money')->textInput()->label('Số buổi còn lại') ?>

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
            <div id="card-info" class="box box-success" style="display: none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Thông tin thẻ</h3>
                </div>
                <div class="box-body">
                    <div id="card-info-detail"></div>
                </div>
            </div>

            <div class="box box-success">
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
                                <tbody id="card-service-info-detail">
                                <?php
                                if ($model->service_combo) {
                                    $serviceIds = json_decode($model->service_combo);
                                    $detail = '';
                                    foreach ($serviceIds as $serv) {
                                        $key = $serv->service;
                                        $value = $serv->time;
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
