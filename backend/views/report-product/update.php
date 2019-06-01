<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\ReportProduct */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Report Product',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Report Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="report-product-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
