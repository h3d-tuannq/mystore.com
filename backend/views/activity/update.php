<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;

$this->title = 'Làm dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Danh sách lịch làm dịch vụ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$urlService = \yii\helpers\Url::to(['service/list']);
$url = \yii\helpers\Url::to(['customer/list']);
// Get the initial city description
$customerName = empty($model->customer_id) ? '' : \common\models\Customer::findOne($model->customer_id)->name;
$serviceName = empty($model->service_id) ? '' : \common\models\Service::findOne($model->service_id)->name;

$script = <<< JS
$("#btn-add-service").on('click',function(){        
    $('#modal-add-service').modal('show');          
});

$("#btn-add-product").on('click',function(){        
    $('#modal-add-product').modal('show');          
});  
JS;


$this->registerJs($script, \yii\web\View::POS_READY);
?>
<?php \yii\widgets\Pjax::begin() ?>
<?php $form = ActiveForm::begin(); ?>
    <section class="content" style="min-height: 1200px">
        <div class="row">
            <div class="col-md-3">

                <!-- /. box -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cập nhật Lịch làm dịch vụ</h3>
                    </div>
                    <div class="box-body">
                        <div class="appointment-form">


                            <?php echo $form->errorSummary($model); ?>

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
                            <?php echo $form->field($model, 'customer_id')->widget(\kartik\select2\Select2::classname(), [
                                'initValueText' => $customerName, // set the initial display text
                                'options' => ['placeholder' => 'Tìm kiếm khách hàng ...'],
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
                                    'templateResult' => new JsExpression('function(customer) { return customer.text; }'),
                                    'templateSelection' => new JsExpression('function (customer) { return customer.text; }'),
                                ],
                            ]); ?>
                            <?php echo $form->field($model, 'start_time')->widget(\kartik\datetime\DateTimePicker::className(), [
                                //'name' => 'dp_2',
                                'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy hh:ii'
                                ]
                            ]); ?>
                            <?php echo $form->field($model, 'end_time')->widget(\kartik\datetime\DateTimePicker::className(), [
                                //'name' => 'dp_2',
                                'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy hh:ii'
                                ]
                            ]); ?>

                            <?php echo $form->field($model, 'service_id')->widget(\kartik\select2\Select2::classname(), [
                                'initValueText' => $serviceName, // set the initial display text
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

                            <?php //echo $form->field($model, 'employee_id')->textInput() ?>
                            <?php echo $form->field($model, 'employee_id')->widget(\kartik\select2\Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\common\models\Employee::find()->all(), 'id', 'name'),
                                'options' => ['placeholder' => 'Chọn nhân viên'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>

                            <?php echo $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

                            <div class="row">
                                <div class="col-md-12"><h5>Chiết khấu cho lễ tân</h5></div>
                                <div class="col-md-12">
                                    <?php echo $form->field( $model, 'reception_id' )->widget( \kartik\select2\Select2::classname(), [
                                        'data'          => \yii\helpers\ArrayHelper::map( \common\models\Employee::getReceptions(), 'id', 'name' ),
                                        'options'       => [ 'placeholder' => 'Chọn lễ tân' ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ] ); ?>

                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <?php
                                        // if($model->rate_reception){
                                            echo Html::tag('p','Doanh thu '.Yii::$app->formatter->asCurrency($model->rate_reception, 'VND'));
                                        //}else{
                                            echo $form->field( $model, 'rate_reception_input', [] )->textInput( [ 'class' => 'form-control' ] )->label('Doanh thu câp nhât lai hoăc để trống để tính tự đông');
                                        //}
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $form->field($model, 'bed')->textInput(['maxlength' => true]) ?>

                            <?php echo $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

                            <?php //echo $form->field($model, 'status')->textInput() ?>



                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">

                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-service" data-toggle="tab" aria-expanded="true">Dịch vụ sử
                                    dụng</a></li>
                            <li class=""><a href="#tab-product" data-toggle="tab" aria-expanded="false">Sản phẩm tiêu
                                    hao</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-service">
                                <!-- Post -->
                                <div class="row">
                                    <div class="pull-right">
                                        <?= \yii\helpers\Html::button('<i class="fa fa-plus"></i> Thêm dịch vụ',
                                            [
                                                'id' => 'btn-add-service',
                                                'title' => 'Thêm dịch vụ',
                                                'class' => 'btn btn-sm btn-primary',
                                                'data-title' => 'Thêm dịch vụ',
                                            ]); ?>
                                    </div>
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="15%">Mã</th>
                                                <th width="35%">Dịch vụ</th>
                                                <th width="10%">Số lượng</th>
                                                <th width="15%">Giá</th>
                                                <th width="10%">Thời gian</th>
                                            </tr>
                                            </thead>
                                            <tbody id="service-info-detail">
                                            <?php
                                            if ($model->detail) {
                                                $services = json_decode($model->detail);
                                                $detail = '';
                                                foreach ($services as $key=>$serv) {
                                                    $value = $serv->amount;
                                                    $service = \common\models\Service::findOne($key);
                                                    if ($service) {

                                                        $detail .= "<tr>";
                                                        $detail .= "<td>" . $service->slug . " </td>";
                                                        $detail .= "<td>" . $service->name . " </td>";
                                                        $detail .= "<td><input type='text' class='form-control' name='Activity[services][" . $service->id . "][amount]'  value='" . $value . "' /></td>";
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
                                <!-- /.post -->
                            </div>

                            <div class="tab-pane" id="tab-product">
                                <div class="row">
                                    <div class="pull-right">
                                        <?= \yii\helpers\Html::button('<i class="fa fa-plus"></i> Thêm sản phẩm',
                                            [
                                                'id' => 'btn-add-product',
                                                'title' => 'Thêm sản phẩm',
                                                'class' => 'btn btn-sm btn-primary',
                                                'data-title' => 'Thêm sản phẩm',
                                            ]); ?>
                                    </div>
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th width="15%">Mã</th>
                                                <th width="35%">Sản phẩm</th>
                                                <th width="10%">Số lượng</th>
                                                <th width="10%">Đơn vị</th>
                                                <th width="15%">Giá</th>
                                                <th width="15%">Thành tiền</th>
                                            </tr>
                                            </thead>
                                            <tbody id="product-info-detail">
                                            <?php
                                            $total = 0;
                                            if ($detail_products) {
                                                $detail = '';

                                                foreach ($detail_products as $detail_product) {
                                                    $detail .= "<tr><th colspan='6'  class=\"bg-primary\">Dịch vụ: $detail_product->service_name </th></tr>";
                                                    $products = $detail_product->products;
                                                    foreach ($products as $product) {
                                                        $detail .= "<tr>";
                                                        $detail .= "<td>" . $product->slug . " </td>";
                                                        $detail .= "<td>" . $product->name . " </td>";
                                                        $detail .= "<td><input type='text' class='form-control' name='Activity[products][" . $detail_product->service_id . "][" . $product->product_id . "][amount]'  value='" . $product->amount . "' /></td>";
                                                        $detail .= "<td>" . $product->unit . " </td>";
                                                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->unit_price, 'VND') . "<input type='hidden' class='form-control' name='Activity[products][" . $detail_product->service_id . "][" . $product->product_id . "][money]'  value='" . $product->unit_price . "' /></td>";
                                                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->money, 'VND') . "  </td>";
                                                        $detail .= "</tr>";

                                                        $total += $product->money;
                                                    }
                                                }
                                                if ($detail) {
                                                    echo $detail;
                                                }
                                            } ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="5" align="right">Tổng tiền:</td>
                                                <td><?= Yii::$app->formatter->asCurrency($total, 'VND') ?></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>

                        <div class="form-group text-center">
                            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Đặt lịch') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            <?php echo Html::a('Danh sách',['index'],['class' => 'btn btn-success']) ?>
                            <?php echo Html::a('Lịch làm dịch vụ',['do-service'],['class' => 'btn btn-success']) ?>
                            <br/>
                            <br/>
                        </div>
                            <p class="text-info"> Chú ý: Sau khi thêm mới hoặc cập nhật số lượng cần Cập nhật lại</p>

                        <!-- /.tab-content -->
                    </div>


                </div>

            </div>
        </div>
        <!-- /.col -->
        </div>

    </section>


<?php \yii\bootstrap\Modal::begin([
    'header' => '<h4>Thêm dịch vụ trong combo</h4>',
    'id' => 'modal-add-service',
    'size' => 'modal-lg',
]);

echo "<div id='modalServiceContent'>";
echo $this->render('_form_add_service', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
echo "</div>";
\yii\bootstrap\Modal::end(); ?>


<?php \yii\bootstrap\Modal::begin([
    'header' => '<h4>Thêm sản phẩm trong dịch vụ</h4>',
    'id' => 'modal-add-product',
    'size' => 'modal-lg',
]);

echo "<div id='modalProductContent'>";
echo $this->render('_form_add_product', [
    'searchModel' => $searchProductModel,
    'dataProvider' => $dataProductProvider,
]);
echo "</div>";
\yii\bootstrap\Modal::end(); ?>

<?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end() ?>
