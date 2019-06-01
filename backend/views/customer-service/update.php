<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\CustomerService */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Customer Service',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Customer Services'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="customer-service-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
