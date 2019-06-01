<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ProductType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-view">

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
            'slug',
            'name',
            'group',
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
        ],
    ]) ?>

</div>
