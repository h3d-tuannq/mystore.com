<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistory */

$this->title = 'Cập nhật lịch sử dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Lịch sử khách hàng'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="customer-history-update">
	<?php echo Html::a(Yii::t('backend', '<- Khách hàng'), ['customer/view','id'=>$model->customer_id], ['class' => 'btn btn-success']) ?>
	<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">



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

	                <?php echo $form->field($model, 'object_id')->dropDownList(\yii\helpers\ArrayHelper::map(
		                \common\models\Service::find()->where(['id' => $model->object_id])->all(),
		                'id',
		                'name'
	                ))->label('Dịch vụ'); ?>

	                <h4>Ngày: <?= Yii::$app->formatter->asDate($model->started_date) ?></h4>
	                <h4>Tổng số buổi: <?= $model->amount ?></h4>
	                <h4>Số buổi đã dùng: <?= $model->sub ?></h4>
	                <h4>Số buổi còn lại: <?= $model->remain ?></h4>
	                <p>Ghi chú: <?= $model->note ?></p>

                    <div class="form-group">
		                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>




                </div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#formservice" data-toggle="tab" aria-expanded="false">Chọn các dịch vụ</a></li>
                    <li class=""><a href="#service" data-toggle="tab" aria-expanded="true">Thông tin đã sử dụng dịch vụ</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="service">
                        <div class="row">
                            <div class="col-xs-12 table-responsive">

							    <?php
							    if ($model->details) {
								    echo '<ul>';
								    foreach ($model->details as $detail) {
									    echo '<li>Ngày ' . Yii::$app->formatter->asDate($detail->used_at) . ': '.$detail->note.' :'. $detail->amount.'</li>';
								    }
								    echo '</ul>';
							    } ?>
                            </div>
                            <!-- /.col -->

                        </div>
                    </div>

                    <div class="tab-pane active" id="formservice">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th width="15%">Mã</th>
                                            <th width="35%">Dịch vụ</th>
                                            <th width="15%">Ngày(30-10-2018)</th>
                                            <th width="10%">Số lượng</th>
                                            <th width="15%">Giá</th>
                                            <th width="10%">Thời gian</th>
                                        </tr>
                                        </thead>
                                        <tbody>
									    <?php
									    if ($model->service && $model->service->services) {
										    $detail = '';
										    foreach ($model->service->services as $serv) {
											    $key = $serv->service_id;
											    $value = 0;
											    $service = \common\models\Service::findOne($key);
											    if ($service) {

												    $detail .= "<tr>";
												    $detail .= "<td>" . $service->slug . " </td>";
												    $detail .= "<td>" . $service->name . " </td>";
												    $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[services][" . $service->id . "][used_at]'  value='' /></td>";
												    $detail .= "<td><input type='text' class='form-control' name='CustomerHistory[services][" . $service->id . "][amount]'  value='" . $value . "' /></td>";
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
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>


        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>