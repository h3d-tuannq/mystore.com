<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EmployeeTimesheet */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Employee Timesheet',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Timesheets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-timesheet-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
