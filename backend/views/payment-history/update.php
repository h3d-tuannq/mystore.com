<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\PaymentHistory */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Payment History',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Payment Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="payment-history-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
