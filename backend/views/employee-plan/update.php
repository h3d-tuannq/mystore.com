<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\EmployeePlan */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Employee Plan',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="employee-plan-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
