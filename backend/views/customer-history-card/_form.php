<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryCard */
/* @var $form yii\bootstrap\ActiveForm */

$url = Yii::$app->request->baseUrl . '/card/info';
$script = <<< SCRIPT
    // Add sản phẩm
    $("#btn-add-product").on('click',function(){
        $('#modal-add-product').modal('show');
    });    
    
    $("#btn-add-service").on('click',function(){
        $('#modal-add-service').modal('show');
    });
    $("#select-card").on('change',function(){

        $.ajax({
            url: '$url',
            type: 'post',
            data: {
                card_id: $(this).val(),
            },
            success: function (data) {
                //console.log(data);
                $("#amount").val(data.total_price);
                $("#card-info").hide();
                if(data.card_type == 'the-dich-vu'){
                    $("#add-service").hide();
                    $("#customer_money").hide();
                    $("#card-product-info").hide();
                    $("#card-service-info").show();
                    $("#card-service-info-detail").html(data.detail);
                }else{
                
                    $("#add-service").show();
                    $("#customer_money").show();
                    $("#card-service-info").show();
                    $("#card-product-info").show();
                    $("#card-service-info-detail").html(data.detail);
                    
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
    $("#select-card").change();
SCRIPT;
$this->registerJs($script, \yii\web\View::POS_READY);
$this->registerJs($scriptLoad, \yii\web\View::POS_LOAD);
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

                    <?php if ($isNew) {
                        echo $form->field($model, 'card_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Card::find()->all(),
                            'id',
                            'name'
                        ), ['prompt' => '', 'id' => 'select-card']);

                    } else {
                        echo $form->field($model, 'card_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                            \common\models\Card::find()->where(['id' => $model->card_id])->all(),
                            'id',
                            'name'
                        ), ['id' => 'select-card']);
                    }
                    ?>


                    <?php echo $form->field($model, 'started_date')->widget(
                        \trntv\yii\datetime\DateTimeWidget::class,
                        [
                            'phpDatetimeFormat' => 'yyyy-MM-dd',
                        ]
                    ) ?>
                    <div id="customer_money" style="display: none">
                        <?php echo $form->field($model, 'amount')->textInput(['id' => 'amount']); ?>
                    </div>

                    <?php echo $form->field($model, 'sub_money')->textInput() ?>

                    <?php echo $form->field($model, 'money')->textInput() ?>

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

            <div id="card-service-info" class="box box-success" style="display: none;">
                <div class="box-header with-border">
                    <h3 class="box-title">Bao gồm các dịch vụ</h3>
                    <div id="add-service" class="pull-right">
                        <?= Html::button('<i class="fa fa-plus"></i> Thêm dịch vụ',
                            [
                                'id' => 'btn-add-service',
                                'title' => 'Thêm dịch vụ',
                                'class' => 'btn btn-sm btn-primary',
                                'data-title' => 'Thêm dịch vụ',
                            ]); ?>
                    </div>
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
                            </table>
                        </div>
                        <!-- /.col -->

                    </div>
                </div>
            </div>

            <div id="card-product-info" class="box box-success" style="display: none;">
                <div class="box-header with-border">
                    <div class="pull-left"><h3 class="box-title">Sản phẩm</h3></div>
                    <div class="pull-right">
                        <?= Html::button('<i class="fa fa-plus"></i> Thêm sản phẩm',
                            [
                                'id' => 'btn-add-product',
                                'title' => 'Thêm sản phẩm',
                                'class' => 'btn btn-sm btn-primary',
                                'data-title' => 'Thêm sản phẩm',
                            ]); ?>
                    </div>
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
                                    <!--                                        <th width="10%">Thời gian</th>-->
                                </tr>
                                </thead>
                                <tbody id="card-product-detail">
                                <?php if ($model->card_product) {
                                    $productIds = json_decode($model->card_product);
                                    $detail = '';
                                    foreach ($productIds as $serv) {
                                        $key = $serv->product;
                                        $value = $serv->time;
                                        $product = \common\models\Product::findOne($key);
                                        if ($product) {

                                            $detail .= "<tr>";
                                            $detail .= "<td>" . $product->slug . " </td>";
                                            $detail .= "<td>" . $product->name . " </td>";
                                            $detail .= "<td><input type='text' class='form-control' name='CustomerHistoryCard[products][" . $product->id . "]' value='" . $value . "' /></td>";
                                            $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->retail_price, 'VND') . "  </td>";
                                            //$detail .= "<td>".$product->duration." </td>";
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
