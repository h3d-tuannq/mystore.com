<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
?>

<div class="box box-primary">

    <div class="box-body">
        <h3>Thông tin cơ bản</h3>
        <?php echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'slug',
                'name',
                'description:ntext',
                'product_type_id',
                //'product_unit_id',
                'product_unit',
                'quantity',
                'specification',
                'input_price',
                'retail_price',
                'rate_employee',
                'discount_money',
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        switch ($model->status) {
                            case \common\models\Common::STATUS_DELETED:
                                $status = 'Đã xóa';
                                break;
                            case \common\models\Common::STATUS_ACTIVE:
                                $status = 'Hoạt động';
                                break;
                            case \common\models\Common::STATUS_ACTIVE:
                            default:
                                $status = 'Không hoạt động';
                        }
                        return $status;
                    }
                ],
                //'thumbnail_base_url:url',
                //'thumbnail_path',
                'created_at:datetime',
                'updated_at:datetime',
                //'created_by',
                //'updated_by',
                'product_date',
                'product_time_use:datetime',
                [
                    'attribute' => 'is_notification',
                    'value' => function ($model) {
                        return $model->is_notification ? 'Đã bật ' : 'Chưa bật';
                    }
                ]

            ],
        ]) ?>
    </div>
</div>

