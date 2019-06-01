<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryService */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customer History Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-history-service-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'service_id',
            'started_date',
            'amount',
            'amount_use',
            'amount_remain',
            'note',
            [
                'attribute'=>'status',
                'value'=> function($model){
                    switch($model->status){
                        case \common\models\Common::STATUS_DELETED: $status = 'Đã xóa';break;
                        case \common\models\Common::STATUS_ACTIVE: $status = 'Hoạt động';break;
                        case \common\models\Common::STATUS_ACTIVE:
                        default: $status = 'Không hoạt động';
                    }
                    return $status;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
