<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceType */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Service Type',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Service Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="service-type-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
