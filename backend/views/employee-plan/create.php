<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\EmployeePlan */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Employee Plan',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-plan-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
