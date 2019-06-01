<?php
/* @var $this yii\web\View */

$this->title = 'Làm dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Danh sách lịch làm dịch vụ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="content"  style="min-height: 1200px">
    <div class="row">
        <div class="col-md-3">

            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Làm dịch vụ</h3>
                </div>
                <div class="box-body">
                    <?php echo \yii\widgets\DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'customer_id',
                                'value' => function($model){
                                    return $model->customer? $model->customer->name : '';
                                }
                            ],
                            [
                                'attribute' => 'service_id',
                                'value' => function($model){
                                    return $model->service->name;
                                }
                            ],
                            'start_time:datetime',
                            'end_time:datetime',
                            'discount',
                            'status',
                            'note',
                            'created_at:datetime',
                            'updated_at:datetime',
                            //'created_by',
                            //'updated_by',
                        ],
                    ]) ?>

                    <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php echo \yii\helpers\Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Sản phẩm tiêu hao</h3>
                </div>
                <div class="box-body no-padding">
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
                            if ($model->serviceProducts) {
                                $detail = '';
                                foreach ($model->serviceProducts as $serviceProduct) {
                                    $product = $serviceProduct->product;
                                    $detail .= "<tr>";
                                    $detail .= "<td>" . $product->slug . " </td>";
                                    $detail .= "<td>" . $product->name . " </td>";
                                    $detail .= "<td><input type='text' class='form-control' name='Activity[services][" . $product->id . "][amount]'  value='" . $serviceProduct->amount . "' /></td>";
                                    $detail .= "<td>" . $serviceProduct->unit . " </td>";
                                    $detail .= "<td><input type='text' class='form-control' name='Activity[services][" . $product->id . "][money]'  value='" . $serviceProduct->money . "' /></td>";
                                    $detail .= "<td>" . Yii::$app->formatter->asCurrency($product->retail_price, 'VND') . "  </td>";
                                    $detail .= "</tr>";
                                }
                                if ($detail) {
                                    echo $detail;
                                }
                            } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" align="right">Tổng tiền:</td>
                                <td><?= Yii::$app->formatter->asCurrency(123123, 'VND') ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>

</section>

