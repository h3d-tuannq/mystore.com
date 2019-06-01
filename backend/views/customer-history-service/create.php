<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomerHistoryService */

$this->title = 'Thêm lịch sử dịch vụ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Lịch sử dịch vụ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-history-service-create">
    <?php echo Html::a(Yii::t('backend', '<- Khách hàng'), ['customer/view','id'=>$model->customer_id], ['class' => 'btn btn-success']) ?>
    <?php echo $this->render('_form', [
        'model' => $model,
        'isNew'=>true
    ]) ?>

</div>
