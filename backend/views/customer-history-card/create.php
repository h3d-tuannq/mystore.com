<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryCard */

$this->title = 'Thêm mới lịch sử thẻ';
$this->params['breadcrumbs'][] = ['label' => 'Lịch sử thẻ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-history-card-create">
    <?php echo Html::a(Yii::t('backend', '<- Khách hàng'), ['customer/view','id'=>$model->customer_id], ['class' => 'btn btn-success']) ?>
    <?php echo $this->render('_form', [
        'model' => $model,
        'products' =>$products,
        'isNew'=>true
    ]) ?>

</div>
