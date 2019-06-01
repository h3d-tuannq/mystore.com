<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeTimesheet */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Employee Timesheet',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Timesheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="employee-timesheet-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
