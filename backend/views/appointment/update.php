<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Appointment',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="appointment-update">

    <?php echo $this->render('_form', [
        'model' => $model,'customers' => $customers,
    ]) ?>

</div>
