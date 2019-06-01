<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\PaymentHistory */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Payment History',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Payment Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-history-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
