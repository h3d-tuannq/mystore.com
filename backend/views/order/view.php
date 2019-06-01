<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = "Đơn hàng $model->id";
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
    <div class="row">
        <div class="col-md-3">

            <!-- /. box -->
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Thông tin</h3>
                </div>
                <div class="box-body">
                    <?php echo $this->render('_view_info', [
                        'model' => $model,
                    ]) ?>
                    <!-- /input-group -->
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="pull-left"><h3 class="box-title">Sản phẩm và dịch vụ</h3></div>

                    <div class="pull-right">
                        <?= Html::button('<i class="fa fa-plus"></i> Thêm thẻ',
                            [
                                'value' => \yii\helpers\Url::to(['order/add-card', 'id' => $model->id]),
                                'title' => 'Thêm sản phẩm',
                                'class' => 'showModalButton btn btn-sm btn-primary',
                                'data-title' => 'Thêm thẻ vào đơn hàng',
                            ]); ?>
                        <?= Html::button('<i class="fa fa-plus"></i> Thêm dịch vụ',
                            [
                                'value' => \yii\helpers\Url::to(['order/add-service', 'id' => $model->id]),
                                'title' => 'Thêm sản phẩm',
                                'class' => 'showModalButton btn btn-sm btn-primary',
                                'data-title' => 'Thêm dịch vụ vào đơn hàng',
                            ]); ?>
                        <?= Html::button('<i class="fa fa-plus"></i> Thêm sản phẩm',
                            [
                                'value' => \yii\helpers\Url::to(['order/add', 'id' => $model->id]),
                                'title' => 'Thêm sản phẩm',
                                'class' => 'showModalButton btn btn-sm btn-primary',
                                'data-title' => 'Thêm sản phẩm vào đơn hàng',
                            ]); ?>
                    </div>
                </div>
                <div class="box-body">
                    <?php echo $this->render('_view_product', [
                        'model' => $model,
                    ]) ?>
                    <?php echo $this->render('_view_amount', [
                        'model' => $model,
                    ]) ?>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->

            <?php echo $this->render('_view_payment', [
                'model' => $model,
            ]) ?>
            <?php $form = \yii\widgets\ActiveForm::begin( [
                'options' => [
                    'id' => 'update-order-form',
                ]
            ] ); ?>
            <div class="form-group text-center">
                <?php echo Html::submitButton('Cập nhật hóa đơn', [
                    'class' => 'btn btn-lg btn-success',
                    'name' => 'submit',
                    'value' => 'update'
                ]) ?>
                <?php echo Html::submitButton('Hoàn tất', [
                    'class' => 'btn btn-lg btn-danger',
                    'name' => 'submit',
                    'value' => 'finish'
                ]) ?>
            </div>
            <input type="hidden" name="id" value="<?= $model->id ?>">
            <?php \yii\widgets\ActiveForm::end(); ?>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>


