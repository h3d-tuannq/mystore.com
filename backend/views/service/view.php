<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-view">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <h3>Thông tin cơ bản</h3>
                     <?php echo $this->render('_view_info', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <?php if ('combo' == $model->serviceType->slug) { ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <div class="pull-left"><h3 class="box-title">Bao gồm các dịch vụ</h3></div>

                        <div class="pull-right">
                            <?= Html::button('<i class="fa fa-plus"></i> Thêm dịch vụ',
                                [
                                    'value' => \yii\helpers\Url::to(['service/find-service', 'id' => $model->id]),
                                    'title' => 'Thêm dịch vụ',
                                    'class' => 'showModalButton btn btn-sm btn-primary',
                                    'data-title' => 'Thêm dịch vụ dùng cho dịch vụ Combo',
                                ]); ?>
                        </div>
                    </div>

                    <div class="box-body">
                        <?php echo $this->render('_view_service', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>

            <?php } ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="pull-left"><h3 class="box-title">Sản phẩm dùng cho dịch vụ</h3></div>
                    <?php if ('combo' != $model->serviceType->slug) { ?>
                        <div class="pull-right">
                            <?= Html::button('<i class="fa fa-plus"></i> Thêm sản phẩm',
                                [
                                    'value' => \yii\helpers\Url::to(['service/add', 'id' => $model->id]),
                                    'title' => 'Thêm sản phẩm',
                                    'class' => 'showModalButton btn btn-sm btn-primary',
                                    'data-title' => 'Thêm sản phẩm dùng cho dịch vụ',
                                ]); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="box-body">
                    <?php echo $this->render('_view_product', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>


</div>
