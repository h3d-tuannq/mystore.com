<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\EmployeeType */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Employee Type',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="employee-type-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
