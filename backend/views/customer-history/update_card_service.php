<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistory */

$this->title = 'Cập nhật lịch sử thẻ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Lịch sử khách hàng'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

$script = <<< JS
    $("#btn-add-product").on('click',function(){
        $('#modal-add-product').modal('show');
    });    
    
    $("#btn-add-service").on('click',function(){
        $('#modal-add-service').modal('show');
    });
JS;
$this->registerJs($script,\yii\web\View::POS_READY);
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
		                \common\models\Card::find()->where(['id' => $model->object_id])->all(),
		                'id',
		                'name'
	                ))->label('Thẻ'); ?>
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

	                            <?= Html::button('<i class="fa fa-plus"></i> Thêm dịch vụ',
		                            [
			                            'id' => 'btn-add-service',
			                            'title' => 'Thêm dịch vụ',
			                            'class' => 'btn btn-sm btn-primary',
			                            'data-title' => 'Thêm dịch vụ',
		                            ]); ?>
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
                                        <tbody id="service-info-detail">
									    <?php
									    if ($model->card && $model->card->services) {
										    $detail = '';
										    foreach ($model->card->services as $serv) {
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
	<?php ActiveForm::end(); ?>
</div>



<?php \yii\bootstrap\Modal::begin([
	'header' => '<h4>Thêm dịch vụ</h4>',
	'id' => 'modal-add-service',
	'size' => 'modal-lg',
]);
$searchModel = new \common\models\search\ServiceSearch();
$dataProvider = $searchModel->searchForCombo(Yii::$app->request->queryParams);
$dataProvider->pagination->pageSize = 500;

echo "<div id='modalServiceContent'>";
echo $this->render('_form_add_service', ['searchModel' => $searchModel,
                                         'dataProvider' => $dataProvider,]);
echo "</div>";
\yii\bootstrap\Modal::end(); ?>


<?php \yii\bootstrap\Modal::begin([
	'header' => '<h4>Thêm sản phẩm</h4>',
	'id' => 'modal-add-product',
	'size' => 'modal-lg',
]);
$productSearchModel = new \common\models\search\ProductSearch();
$productDataProvider = $productSearchModel->search(Yii::$app->request->queryParams);
$productDataProvider->pagination->pageSize = 500;

echo "<div id='modalProductContent'>";
echo $this->render('_form_add_product', ['searchModel' => $searchModel,
                                         'dataProvider' => $productDataProvider,]);
echo "</div>";
\yii\bootstrap\Modal::end(); ?>