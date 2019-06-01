<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\EmployeeType */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Employee Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employee Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-type-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
