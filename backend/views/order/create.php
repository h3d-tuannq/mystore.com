<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Tạo hóa đơn';
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>