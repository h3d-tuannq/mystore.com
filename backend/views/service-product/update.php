<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceProduct */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Service Product',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Service Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="service-product-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
